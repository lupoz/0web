<?php

namespace App\Filament\Resources;

use Closure;


use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\CreateAction;
use CodeWithDennis\FilamentSelectTree\SelectTree;


use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Http\Controllers\ChatGPT;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;

use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make()
                ->schema([

                    // FIRST COLUMN
                    Grid::make('Category info')
                        // ->description('Prevent abuse by limiting the number of requests per period')
                        ->schema([
                            Section::make('Category info')
                                //  ->description('Prevent abuse by limiting the number of requests per period')
                                ->schema([
                                    Grid::make()
                                        ->schema([

                                            TextInput::make('name')
                                                ->required()
                                                ->placeholder('Gaming')
                                                ->lazy()
                                                ->suffixAction(
                                                    Action::make('UpDate fields')
                                                        ->icon('heroicon-m-cube-transparent')
                                                )->id("name")
                                                ->columnSpan(10),

                                            Toggle::make('active')
                                                ->onColor('success')
                                                ->offColor('danger')
                                                ->default(true)
                                                ->inline(false)
                                                ->columnSpan(2),

                                            MarkdownEditor::make('full_description')->id('full_description')->columnSpan(12)

                                        ])->columns(12),
                                ]),

                        ])->columnSpan(6),

                    // SECOND COLUMN
                    Grid::make()
                        ->schema([
                            Section::make('SEO info')
                                // ->description('Prevent abuse by limiting the number of requests per period')
                                ->schema([

                                    TextInput::make('title')
                                        ->maxLength(60)
                                        ->id("title")
                                        ->placeholder('Migliori siti di Gaming')
                                        ->hint(fn ($state, $component) => $component->getMaxLength() - strlen($state) . ' / ' . $component->getMaxLength())->reactive(),

                                    TextInput::make('slug')
                                        ->id("slug")
                                        ->placeholder('migliori-siti-gaming')
                                        ->required(),

                                    Textarea::make('meta_description')
                                        ->hint(fn ($state, $component) => $component->getMaxLength() - strlen($state) . ' / ' . $component->getMaxLength())
                                        ->maxLength(160)
                                        ->reactive()
                                        ->extraAttributes(['class' => 'meta_description']),
                                ])->columnSpan(6),

                            Section::make('Category Advice')
                                //  ->description('Prevent abuse by limiting the number of requests per period')
                                ->schema([

                                    Radio::make('message_type')
                                        ->options([
                                            'draft' => 'Draft',
                                            'scheduled' => 'Scheduled',
                                            'published' => 'Published'
                                        ])
                                        ->inline()
                                        ->inlineLabel(false)
                                        ->columnSpan(12),

                                    Textarea::make('message_text')
                                        ->placeholder('Danger, warning, or informational advice...')
                                        ->columnSpan(12)

                                ])->columnSpan(6)
                        ])->columnSpan(6)

                ])->columns(12)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}