<?php

namespace App\Http\Controllers\Datamine;

use App\Http\Controllers\Controller;
use App\Repositories\LeadRepository;
use App\Services\Datamine\FileService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class ImportFileController extends Controller
{
    /**
     * @var \App\Repositories\LeadRepository
     */
    protected $leadRepository;

    public function __construct(LeadRepository $leadRepository)
    {
        $this->leadRepository = $leadRepository;
    }

    public function index()
    {
        return view(backpack_view('base.datamine.sendfile'));
    }

    public function store(Request $request)
    {
        if (!$request->hasFile('file')) {
            Alert::add('error', 'Informar um arquivo')->flash();
            return redirect()->back()->withInput();
        }

        $fileType = 'TYPE_' . $request->input('file_type') ?? 'file';
        $dateQuarter = 'QUARTER_' . $request->input('date_quarter') ?? 'date';
        $dateYear =  'YEAR_' . ($request->input('date_year') ?? 'date');
        $originalName = $request->file->getClientOriginalName();
        $name = 'NAME_' . pathinfo($originalName, PATHINFO_FILENAME);
        $extension = $request->file->getClientOriginalExtension();
        $time = 'TIME_' . time();

        $fileNameToStore =
            $fileType . '_' .
            $dateYear . '_' .
            $dateQuarter . '_' .
            $name . '_' .
            $time . '.' .
            $extension;

        $content = $request->file;

        Storage::disk('local')->putFileAs(FileService::LOCAL, $content, $fileNameToStore);

        Alert::add('success', 'Arquivo salvo!')->flash();
        return redirect()->back();
    }
}
