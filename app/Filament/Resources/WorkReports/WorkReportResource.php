<?php

namespace App\Filament\Resources\WorkReports;

use App\Filament\Resources\WorkReports\Pages\CreateWorkReport;
use App\Filament\Resources\WorkReports\Pages\EditWorkReport;
use App\Filament\Resources\WorkReports\Pages\ListWorkReports;
use App\Filament\Resources\WorkReports\Schemas\WorkReportForm;
use App\Filament\Resources\WorkReports\Tables\WorkReportsTable;
use App\Models\Position;
use App\Models\WorkReport;
use BackedEnum;
use Filament\Resources\Pages\PageRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class WorkReportResource extends Resource
{
    //TODO TESTING
//    /*** @var string|null */
//    protected static ?string $model = WorkReport::class;
//
//    /*** @var string|null|BackedEnum */
//    protected static string|null|BackedEnum $navigationIcon = 'heroicon-o-document-text';
//
//    /*** @var string|null */
//    protected static ?string $navigationLabel = 'Звіти про роботу';
//
//    /*** @return int */
//    public static function getNavigationSort(): int
//    {
//        return 5;
//    }
//
//    /**
//     * @param Schema $schema
//     * @return Schema
//     */
//    public static function form(Schema $schema): Schema
//    {
//        return WorkReportForm::configure($schema);
//    }
//
//    /**
//     * @param Table $table
//     * @return Table
//     */
//    public static function table(Table $table): Table
//    {
//        return WorkReportsTable::configure($table);
//    }
//
//    /*** @return array|class-string[]|RelationGroup[]|RelationManagerConfiguration[] */
//    public static function getRelations(): array
//    {
//        return [
//            //
//        ];
//    }
//
//    /*** @return array|PageRegistration[] */
//    public static function getPages(): array
//    {
//        return [
//            'index' => ListWorkReports::route('/'),
//            'create' => CreateWorkReport::route('/create'),
//            'edit' => EditWorkReport::route('/{record}/edit'),
//        ];
//    }
//
//    /*** @return Builder */
//    public static function getEloquentQuery(): Builder
//    {
//        $query = parent::getEloquentQuery();
//        if (isRoleNavigator()) {
//
//            $positionData = Position::where('user_id', Auth::id())->first();
//            if ($positionData !== null) {
//                $query->where('position', $positionData->title);
//            }
//        }
//        return $query->orderBy('date');
//    }
}
