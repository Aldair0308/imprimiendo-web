<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\PdfService;

class PdfPageCounter extends Component
{
    public $pdfFile;
    public $totalPages = 0;
    public $pagesToPrint = 0;

    public function mount($pdfFile = null)
    {
        if ($pdfFile) {
            $this->processPdfFile($pdfFile);
        }
    }

    public function processPdfFile($pdfFile)
    {
        try {
            $pdfService = new PdfService();
            $pagesInfo = $pdfService->getPagesInfo($pdfFile);
            
            $this->totalPages = $pagesInfo['total_pages'];
            $this->pagesToPrint = $pagesInfo['pages_to_print']; // Por ahora todas
            
        } catch (\Exception $e) {
            logger('Error in PdfPageCounter: ' . $e->getMessage());
            $this->totalPages = 0;
            $this->pagesToPrint = 0;
        }
    }

    public function updatedPdfFile()
    {
        if ($this->pdfFile) {
            $this->processPdfFile($this->pdfFile);
        }
    }

    public function render()
    {
        return view('livewire.pdf-page-counter');
    }
}