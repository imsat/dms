<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Database\Query\Builder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ChangeDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::table('document_users')
            ->join('users', function (JoinClause $join) {
                $join->on('document_users.user_id', '=', 'users.id')
                    ->where('users.status', '=', 1);
            })
            ->join('document_versions', function (JoinClause $join) {
                $join->on('document_users.document_id', '=', 'document_versions.document_id')
                    ->whereColumn('document_users.last_viewed_version', '=', 'document_versions.version');
            })
            ->join('documents', function (JoinClause $join) {
                $join->on('document_users.document_id', '=', 'documents.id')
                    ->whereColumn('document_users.last_viewed_version', '<>', 'documents.current_version')
                    ->whereColumn('document_users.last_viewed_version', '>', 'documents.current_version')
                    ->where('documents.status', '=', 1);
            })
            ->select('document_users.document_id', 'document_users.last_viewed_version as new_version', 'documents.current_version as old_version', 'document_users.user_id')
            ->distinct()
            ->orderBy('document_users.user_id')
            ->chunk(100, function (Collection $diffs) {
                $changes = [];
                foreach ($diffs as $key => $diff) {
                    $checkExists = DB::table('changes')->where(function (Builder $query) use ($diff) {
                        $query->where('document_id', '=', $diff->document_id)
                            ->where('user_id', '=', $diff->user_id)
                            ->where('new_version', '=', $diff->new_version)
                            ->where('old_version', '=', $diff->old_version);
                    })->first();

                    if (blank($checkExists)) {
                        $changes[$key]['document_id'] = $diff->document_id;
                        $changes[$key]['user_id'] = $diff->user_id;
                        $changes[$key]['new_version'] = $diff->new_version;
                        $changes[$key]['old_version'] = $diff->old_version;
                    }
                }
                DB::table('changes')->insert($changes);
            });
    }
}
