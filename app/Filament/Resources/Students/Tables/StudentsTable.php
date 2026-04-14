<?php

namespace App\Filament\Resources\Students\Tables;

use App\Exports\StudentExport;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Maatwebsite\Excel\Facades\Excel;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('class.name')
                    ->badge(),
                TextColumn::make('section.name')
                    ->badge(),
            ])
            ->filters([
                Filter::make('class-section-filter')
                    ->schema([
                        Select::make('class_id')
                            ->label('Filter by class')
                            ->placeholder('Select a class')
                            ->live()
                            ->options(Classes::pluck('name', 'id')->toArray()),
                        Select::make('section_id')
                            ->label('Filter by section')
                            ->placeholder('select a section')
                            ->options(function (Get $get) {
                                $classId = $get('class_id');

                                return Section::where('class_id', $classId)->pluck('name', 'id')->toArray();
                            }),

                    ])->query(function (Builder $query, array $data) {
                        return $query->when($data['class_id'] ?? null, fn ($query, $classId) => $query->where('class_id', $classId));
                    }),
            ])
            ->recordActions([
                Action::make('downloadPdf')
                    ->url(function (Student $student) {
                        return route('student.invoice.generate', $student);
                    }, shouldOpenInNewTab: true),
                Action::make('Qr Code')
                    ->url(function (Student $record) {
                        return route('filament.admin.resources.students.qrCode', ['record' => $record]);
                    }, shouldOpenInNewTab: true),
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    BulkAction::make('Export')
                        ->label('Export to Excel')
                        ->icon(Heroicon::DocumentArrowDown)
                        ->action(function (EloquentCollection $records) {
                            return Excel::download(new StudentExport($records), 'student.xlsx');
                        }),
                ]),
            ]);
    }
}
