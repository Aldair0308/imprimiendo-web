<?php

namespace App\Services;

class PdfService
{
    public function countPages($filePath)
    {
        if (!file_exists($filePath)) {
            logger('PDF file does not exist: ' . $filePath);
            return 0;
        }

        try {
            $content = file_get_contents($filePath);
            if (empty($content)) {
                logger('PDF content is empty');
                return 0;
            }

            logger('PDF content size: ' . strlen($content) . ' bytes');

            // Method 1: Look for /Type /Pages with /Count
            // This is the most reliable method - PDF structure has /Pages object with /Count
            $count = 0;

            // Try to find the count in Pages object: /Type /Pages /Count X
            if (preg_match('/\/Type\s*\/\s*Pages[^\/]*\/Count\s+(\d+)/i', $content, $matches)) {
                $count = (int) $matches[1];
                logger('Found pages via /Type /Pages /Count: ' . $count);
                return $count > 0 ? $count : 0;
            }

            // Method 2: Try counting /Type /Page occurrences
            $count = preg_match_all('/\/Type\s*\/\s*Page\b/i', $content);
            logger('Found pages via /Type /Page count: ' . $count);

            if ($count == 0) {
                // Method 3: Try counting just /Page occurrences
                $count = preg_match_all('/\/Page\b/', $content);
                logger('Found pages via /Page count: ' . $count);
            }

            // Default to 1 if we found some pages but count is 0
            return $count > 0 ? $count : 1;

        } catch (\Exception $e) {
            logger('Error counting PDF pages: ' . $e->getMessage() . ' File: ' . $filePath);
            return 0;
        }
    }

    public function getPagesInfo($pdfFile)
    {
        if (!$pdfFile) {
            return [
                'total_pages' => 0,
                'pages_to_print' => 0,
                'file_name' => null
            ];
        }

        $tempPath = $pdfFile->path();
        $totalPages = $this->countPages($tempPath);

        return [
            'total_pages' => $totalPages,
            'pages_to_print' => $totalPages,
            'file_name' => $pdfFile->getClientOriginalName()
        ];
    }
}