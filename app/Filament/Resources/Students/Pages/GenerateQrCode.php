<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Str;
use Linkxtr\QrCode\Facades\QrCode;

class GenerateQrCode extends Page
{
    use InteractsWithRecord;

    protected static string $resource = StudentResource::class;

    protected string $view = 'filament.resources.students.pages.generate-qr-code';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        // static::authorizeResourceAccess();
    }

    public function getQrCode(): string
    {
        $student = $this->getRecord();

        $data = [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'class' => $student->class?->name,
            'section' => $student->section?->name,
        ];

        $jsonData = json_encode($data);

        return QrCode::size(300)->generate($jsonData);
    }

    public function downloadQrCode()
    {
        $student = $this->getRecord();
        $fileName = 'student-'.$student->id.'-'.Str::slug($student->name).'-qrcode.svg';

        $data = [
            'id' => $student->id,
            'name' => $student->name,
            'email' => $student->email,
            'class' => $student->class?->name,
            'section' => $student->section?->name,
        ];

        $jsonData = json_encode($data);
        $qrCode = QrCode::size(400)->generate($jsonData);

        return response()->streamDownload(function () use ($qrCode) {
            echo $qrCode;
        }, $fileName, [
            'Content-Type' => 'image/svg+xml',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
        ]);
    }

    public function printPage()
    {
        $this->dispatch('print');
    }
}
