<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use setasign\Fpdi\Fpdi;

class PrintJobConfigurator extends Component
{
    use WithFileUploads;

    public $pdfFile;

    public $color = '1'; // '1' para Color, '0' para B/N

    public $copies = 1;

    public $pageRange = 'all'; // all, even, odd, custom

    public $specificPages = '';

    public $totalPages = 0;

    public $selectedPages = [];

    public function updatedPdfFile()
    {
        $this->validate([
            'pdfFile' => 'required|mimes:pdf|max:10240', // 10MB max
        ]);

        // Count pages in the uploaded PDF
        if ($this->pdfFile) {
            $this->countPdfPages();
        } else {
            $this->totalPages = 0;
            $this->selectedPages = [];
        }
    }

    private function countPdfPages()
    {
        try {
            // Save the file temporarily to count pages
            $tempPath = $this->pdfFile->getRealPath();

            // Using FPDI to count pages
            $pdf = new Fpdi;
            $this->totalPages = $pdf->setSourceFile($tempPath);
        } catch (\Exception $e) {
            $this->totalPages = 0;
        }
    }

    public function updatedPageRange()
    {
        // Reset specific pages when changing page range
        if ($this->pageRange !== 'custom') {
            $this->specificPages = '';
        }
    }

    public function submit()
    {
        $this->validate([
            'pdfFile' => 'required|mimes:pdf|max:10240',
            'copies' => 'required|integer|min:1|max:100',
            'pageRange' => 'required|in:all,even,odd,custom',
            'specificPages' => 'required_if:pageRange,custom',
        ]);

        // Validate specific pages if custom range is selected
        if ($this->pageRange === 'custom' && $this->specificPages) {
            $this->validateCustomPages();
        }

        // Aquí iría la lógica para procesar el trabajo de impresión
        $this->dispatch('print-job-submitted', [
            'color' => $this->color,
            'copies' => $this->copies,
            'pageRange' => $this->pageRange,
            'specificPages' => $this->specificPages,
            'totalPages' => $this->totalPages,
        ]);

        session()->flash('message', '¡Trabajo de impresión enviado correctamente!');
    }

    private function validateCustomPages()
    {
        if (! $this->specificPages) {
            return;
        }

        // Parse page ranges like "1,3,5-10"
        $pages = explode(',', $this->specificPages);
        $validPages = [];
        $invalidRanges = [];

        foreach ($pages as $page) {
            $page = trim($page);
            if (strpos($page, '-') !== false) {
                // Handle page ranges like "5-10"
                [$start, $end] = explode('-', $page);
                $start = (int) $start;
                $end = (int) $end;

                // Validate range
                if ($start > 0 && $end <= $this->totalPages && $start <= $end) {
                    for ($i = $start; $i <= $end; $i++) {
                        $validPages[] = $i;
                    }
                } else {
                    $invalidRanges[] = $page;
                }
            } else {
                // Handle individual pages
                $pageNum = (int) $page;
                if ($pageNum > 0 && $pageNum <= $this->totalPages) {
                    $validPages[] = $pageNum;
                } else {
                    $invalidRanges[] = $page;
                }
            }
        }

        // Remove duplicates and sort
        $validPages = array_unique($validPages);
        sort($validPages);

        // Store validated pages
        $this->selectedPages = $validPages;

        // Show error for invalid pages/ranges
        if (! empty($invalidRanges)) {
            $this->addError('specificPages', 'Algunas páginas están fuera de rango: '.implode(', ', $invalidRanges));
        }
    }

    public function render()
    {
        return view('livewire.print-job-configurator');
    }
}
