<?php

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $diffs = DB::table('document_users')
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
//        ->join('changes', function (JoinClause $join) {
//            $join->on('document_users.document_id', '=', 'changes.document_id')
////                ->orOn('documents.id', '=', 'changes.document_id')
//                ->whereColumn('document_users.user_id', '=', 'changes.user_id')
//                ->whereColumn('document_users.last_viewed_version', '=', 'changes.new_version')
//                ->whereColumn('documents.current_version', '=', 'changes.old_version' );
//        })

//        ->whereNotExists(function ($query) {
//            $query->select(DB::raw(1))
//                ->from('changes')
//                ->join('documents', 'changes.document_id', '=', 'documents.id')
//                ->whereColumn('document_users.document_id', '=', 'changes.document_id')
//                ->whereColumn('document_users.user_id', '=', 'changes.user_id')
//                ->whereColumn('document_users.last_viewed_version', '=', 'changes.new_version');
////                ->whereColumn('changes.old_version', '=',  'documents.current_version');
//        })
        ->select('document_users.document_id', 'document_users.last_viewed_version as new_version', 'documents.current_version as old_version', 'document_users.user_id')
        ->distinct()
//        ->get();
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

//    dd($diffs);

    return view('welcome');
});

