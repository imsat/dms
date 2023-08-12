<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $documents = DB::table('documents')
//            ->rightJoin('document_versions', function (JoinClause $join) {
//                $join->on('documents.id', '=', 'document_versions.document_id')
//                    ->whereColumn('documents.current_version', '=', 'document_versions.version');
//            })
//            ->select('documents.id', 'documents.title', 'documents.current_version', 'documents.status', 'document_versions.body_content', 'document_versions.tags_content')
//            ->paginate(10);
//        dd(auth()->id());

        $documents = DB::table('documents')
            ->join('document_versions', function (JoinClause $join) {
                $join->on('documents.id', '=', 'document_versions.document_id')
                    ->whereColumn('documents.current_version', '=', 'document_versions.version');
            })
//            ->leftJoin('changes', function (JoinClause $join) {
//                $join->on(auth()->id(), '=', 'changes.user_id')
//                    ->whereColumn('document_users.user_id', '=', 'changes.user_id')
//                    ->whereColumn('document_users.last_viewed_version', '=', 'changes.new_version')
//                    ->whereColumn('documents.current_version', '=', 'changes.old_version');
//            })
            ->leftJoin('changes', function (JoinClause $join) {
                $join->on('documents.id', '=', 'changes.document_id')
//                    ->whereColumn('document_users.user_id', '=', 'changes.user_id');
                ->whereColumn('documents.current_version', '=', 'changes.old_version');
//                ->whereColumn('documents.current_version', '=', 'changes.old_version' );
            })
            ->select('documents.id', 'documents.title', 'current_version', 'documents.status as document_status', 'changes.user_id as change_user_id')
            ->paginate();

//        dd($documents);

        return view('document.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($document)
    {
        $document = DB::table('documents')
            ->rightJoin('document_versions', function (JoinClause $join) {
                $join->on('documents.id', '=', 'document_versions.document_id')
                    ->whereColumn('documents.current_version', '=', 'document_versions.version');
            })
            ->select('documents.id', 'documents.title', 'documents.current_version', 'documents.status', 'document_versions.body_content', 'document_versions.tags_content')
            ->find($document);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
