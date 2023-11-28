<?php

namespace Features\Sources\SourceResponses;

use Features\Sources\Source;
use Illuminate\View\View;

class HtmlResponseForSource
{
    public function allSources():View
    {
        $sources = Source::all();
        return view('Source::index', compact('sources'));
    }
}
