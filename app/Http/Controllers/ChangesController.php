<?php

namespace App\Http\Controllers;

use App\Models\Change;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Factory\RendererFactory;
use Jfcherng\Diff\Renderer\RendererConstant;

class ChangesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $changes = Change::with('document:id,title')
            ->whereUserId(auth()->id())
            ->select('id', 'document_id')
            ->paginate();

        return view('change.index', compact('changes'));
    }

    /**
     * Display the specified resource.
     */
    public function show($change)
    {
        $diff = DB::table('changes')
            ->join('documents', 'changes.document_id', '=', 'documents.id')
            ->join('document_versions as new_version', function (JoinClause $join) {
                $join->on('changes.document_id', '=', 'new_version.document_id')
                    ->whereColumn('changes.new_version', '=', 'new_version.version');
            })
            ->join('document_versions as old_version', function (JoinClause $join) {
                $join->on('changes.document_id', '=', 'old_version.document_id')
                    ->whereColumn('changes.old_version', '=', 'old_version.version');
            })
            ->select(['changes.id',
                'new_version.id as new_version_id',
                'new_version.body_content as new_version_body_content',
                'new_version.tags_content as new_version_tags_content',
                'old_version.id as old_version_id',
                'old_version.body_content as old_version_body_content',
                'old_version.tags_content as old_version_tags_content',
                'documents.title',
            ])
            ->where('changes.id', '=', $change)
        ->first();

        $bodyContentDiff = null;
        if(!blank($diff?->old_version_body_content) && $diff?->new_version_body_content){
            $bodyContentDiff = $this->makeDiff($diff->old_version_body_content,$diff->new_version_body_content);
        }

        $tagsContentDiff = null;
        if(!blank($diff?->old_version_tags_content) && $diff?->new_version_tags_content){
            $tagsContentDiff = $this->makeDiff($diff->old_version_tags_content,$diff->new_version_tags_content);
        }

        return view('change.show', compact('diff', 'bodyContentDiff', 'tagsContentDiff'));

    }

    private function makeDiff($old, $new )
    {
        $differOptions = [
            // show how many neighbor lines
            // Differ::CONTEXT_ALL can be used to show the whole file
            'context' => 3,
            // ignore case difference
            'ignoreCase' => false,
            // ignore line ending difference
            'ignoreLineEnding' => false,
            // ignore whitespace difference
            'ignoreWhitespace' => false,
            // if the input sequence is too long, it will just gives up (especially for char-level diff)
            'lengthLimit' => 2000,
        ];

// the renderer class options
        $rendererOptions = [
            // how detailed the rendered HTML in-line diff is? (none, line, word, char)
            'detailLevel' => 'line',
            // renderer language: eng, cht, chs, jpn, ...
            // or an array which has the same keys with a language file
            // check the "Custom Language" section in the readme for more advanced usage
            'language' => 'eng',
            // show line numbers in HTML renderers
            'lineNumbers' => true,
            // show a separator between different diff hunks in HTML renderers
            'separateBlock' => true,
            // show the (table) header
            'showHeader' => true,
            // the frontend HTML could use CSS "white-space: pre;" to visualize consecutive whitespaces
            // but if you want to visualize them in the backend with "&nbsp;", you can set this to true
            'spacesToNbsp' => false,
            // HTML renderer tab width (negative = do not convert into spaces)
            'tabSize' => 4,
            // this option is currently only for the Combined renderer.
            // it determines whether a replace-type block should be merged or not
            // depending on the content changed ratio, which values between 0 and 1.
            'mergeThreshold' => 0.8,
            // this option is currently only for the Unified and the Context renderers.
            // RendererConstant::CLI_COLOR_AUTO = colorize the output if possible (default)
            // RendererConstant::CLI_COLOR_ENABLE = force to colorize the output
            // RendererConstant::CLI_COLOR_DISABLE = force not to colorize the output
            'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
            // this option is currently only for the Json renderer.
            // internally, ops (tags) are all int type but this is not good for human reading.
            // set this to "true" to convert them into string form before outputting.
            'outputTagAsString' => false,
            // this option is currently only for the Json renderer.
            // it controls how the output JSON is formatted.
            // see available options on https://www.php.net/manual/en/function.json-encode.php
            'jsonEncodeFlags' => \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE,
            // this option is currently effective when the "detailLevel" is "word"
            // characters listed in this array can be used to make diff segments into a whole
            // for example, making "<del>good</del>-<del>looking</del>" into "<del>good-looking</del>"
            // this should bring better readability but set this to empty array if you do not want it
            'wordGlues' => [' ', '-'],
            // change this value to a string as the returned diff if the two input strings are identical
            'resultForIdenticals' => null,
            // extra HTML classes added to the DOM of the diff container
            'wrapperClasses' => ['diff-wrapper'],
        ];

        $jsonResult = DiffHelper::calculate($old, $new, 'Json');
        $htmlRenderer = RendererFactory::make('Inline', $rendererOptions);
        $result = $htmlRenderer->renderArray(json_decode($jsonResult, true));
        return $result;

    }

}
