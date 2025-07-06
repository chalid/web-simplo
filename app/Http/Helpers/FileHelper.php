<?php

namespace App\Http\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileHelper
{
    /**
     * Simpan PDF ke folder publik.
     *
     * @param  UploadedFile $file          // file PDF
     * @param  string       $docType       // contoh: 'tax', 'contract', 'hrd'
     * @return string       $storedName    // nama file yang disimpan
     */
    public static function uploadPdf(UploadedFile $file, string $docType): string
    {
        // Pastikan benar‑benar PDF
        if ($file->getMimeType() !== 'application/pdf') {
            throw new \RuntimeException('File bukan PDF');
        }

        // nama acak – hindari tabrakan
        $storedName = Str::random(40) . '.' . $file->getClientOriginalExtension();

        // Path publik   public/storage/upload_files/documents/<type>/ori
        $base = public_path("storage/upload_files/documents/{$docType}/ori");

        // Buat folder jika belum ada
        if (! File::exists($base)) {
            File::makeDirectory($base, 0777, true);
        }

        // Pindahkan file dari TMP ke folder tujuan
        $file->move($base, $storedName);

        return $storedName;  // simpan di DB jika perlu
    }

    /**
     * Hapus PDF lama.
     */
    public static function deletePdf(string $storedName, string $docType): void
    {
        $path = public_path("storage/upload_files/documents/{$docType}/ori/{$storedName}");

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
