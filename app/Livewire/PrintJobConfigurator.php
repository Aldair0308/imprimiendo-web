<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\PdfService;

class PrintJobConfigurator extends Component
{
    use WithFileUploads;

    public $pdfFile;

    public $colorMode = '1'; // '1' para Color, '0' para B/N

    public $totalPages = 0;

    public $selectedPages = ''; // e.g. "1-3,5"

    public $pagesToPrint = 0;

    protected $pdfService;

    public function __construct()
    {
        $this->pdfService = new PdfService();
    }

    public function updatedPdfFile()
    {
        // Count pages immediately when file is selected (not just when submitted)
        if ($this->pdfFile) {
            $this->countPdfPages();
        } else {
            $this->totalPages = 0;
            $this->pagesToPrint = 0;
        }
    }

    private function countPdfPages()
    {
        try {
            if (!$this->pdfFile || !$this->pdfFile->isValid()) {
                $this->totalPages = 0;
                $this->pagesToPrint = 0;
                return;
            }

            // Store file temporarily to ensure it's accessible
            $storedPath = $this->pdfFile->store('temp', 'local');
            $fullPath = storage_path('app/' . $storedPath);

            // Using PdfService to count pages
            $this->totalPages = $this->pdfService->countPages($fullPath);

            // Clean up temp file
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            // Set pages to print to total if no selection
            if (empty($this->selectedPages)) {
                $this->pagesToPrint = $this->totalPages;
            } else {
                $this->pagesToPrint = $this->countSelectedPages();
            }

            // Log para debug
            logger('PDF pages counted: ' . $this->totalPages . ' for file: ' . $this->pdfFile->getClientOriginalName());
        } catch (\Exception $e) {
            logger('Error counting pages: ' . $e->getMessage());
            $this->totalPages = 0;
            $this->pagesToPrint = 0;
        }
    }

    private function countSelectedPages()
    {
        if (empty($this->selectedPages)) {
            return $this->totalPages;
        }

        $pages = $this->parsePages($this->selectedPages, $this->totalPages);
        return count($pages);
    }

    private function parsePages($input, $totalPages)
    {
        $pages = [];
        $parts = explode(',', $input);

        foreach ($parts as $part) {
            $part = trim($part);
            if (strpos($part, '-') !== false) {
                // Range like 1-3
                list($start, $end) = explode('-', $part);
                $start = (int) trim($start);
                $end = (int) trim($end);
                for ($i = $start; $i <= $end; $i++) {
                    if ($i >= 1 && $i <= $totalPages) {
                        $pages[] = $i;
                    }
                }
            } else {
                // Single page
                $page = (int) trim($part);
                if ($page >= 1 && $page <= $totalPages) {
                    $pages[] = $page;
                }
            }
        }

        return array_unique($pages);
    }

    public function updatedColorMode($value)
    {
        $this->colorMode = (string) $value;
        // Force re-render of the preview
        $this->dispatch('color-mode-changed', ['colorMode' => $this->colorMode]);
    }

    public function submit()
    {
        $this->validate([
            'pdfFile' => 'required|mimes:pdf|max:10240',
            'colorMode' => 'required|in:0,1',
        ]);

        // Aquí iría la lógica para procesar el trabajo de impresión
        $this->dispatch('print-job-submitted', [
            'color' => $this->colorMode,
        ]);

        session()->flash('message', '¡Trabajo de impresión enviado correctamente!');
    }

    public function render()
    {
        return view('livewire.print-job-configurator');
    }
}