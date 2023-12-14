<?php

namespace App\Filament\Resources;

use App\Models\Website;



use App\Filament\Resources\WebsiteResource\Pages;
use App\Filament\Resources\WebsiteResource\RelationManagers;

use Closure;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Actions\CreateAction;
use CodeWithDennis\FilamentSelectTree\SelectTree;

use App\Http\Controllers\ChatGPT;
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

class WebsiteResource extends Resource
{
    protected static ?string $model = Website::class;

    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make()
                ->schema([

                    // FIRST COLUMN
                    Grid::make()
                        // ->description('Prevent abuse by limiting the number of requests per period')
                        ->schema([
                            Section::make('Category info')
                                //  ->description('Prevent abuse by limiting the number of requests per period')
                                ->schema([
                                    Grid::make()
                                        ->schema([

                                            TextInput::make('name')
                                                ->required()
                                                ->placeholder('Google')
                                                ->columnSpan(10),

                                            Toggle::make('active')
                                                ->onColor('success')
                                                ->offColor('danger')
                                                ->default(true)
                                                ->inline(false)
                                                ->columnSpan(2),

                                            TextInput::make('Domain')
                                                ->required()
                                                ->url()
                                                ->placeholder('google.it')
                                                ->columnSpan(12)
                                                ->prefix('https://')
                                                ->suffixAction(
                                                    Action::make('UpDate fields')
                                                        ->icon('heroicon-m-globe-alt')
                                                )->id("name"),

                                            TextInput::make('Sponsored Url')
                                                ->url()
                                                ->placeholder('google.it/?user=1234')
                                                ->columnSpan(10)
                                                ->prefix('https://'),

                                            Toggle::make('sponsored')
                                                ->onColor('success')
                                                ->offColor('danger')
                                                ->default(false)
                                                ->inline(false)
                                                ->columnSpan(2),

                                            MarkdownEditor::make('full_description')->id('full_description')->columnSpan(12)

                                        ])->columns(12),

                                ]),

                        ])->columnSpan(6),

                    // SECOND COLUMN
                    Grid::make()
                        ->schema([

                            Section::make('Website details')
                                // ->description('Prevent abuse by limiting the number of requests per period')
                                ->schema([
                                    Radio::make('cost_type')
                                        ->options([
                                            'free' => 'Free',
                                            'fremium' => 'Fremium',
                                            'premium' => 'Premium'
                                        ])
                                        ->inline()
                                        ->inlineLabel(false)
                                        ->columnSpan(12)
                                ])->columnSpan(6),

                            Section::make('SEO info')
                                // ->description('Prevent abuse by limiting the number of requests per period')
                                ->schema([

                                    TextInput::make('title')
                                        ->maxLength(60)
                                        ->id("title")
                                        ->placeholder('Recensione Google')
                                        ->hint(fn ($state, $component) => $component->getMaxLength() - strlen($state) . ' / ' . $component->getMaxLength())->reactive(),

                                    TextInput::make('slug')
                                        ->id("slug")
                                        ->placeholder('google.it')
                                        ->required(),

                                    Textarea::make('meta_description')
                                        ->hint(fn ($state, $component) => $component->getMaxLength() - strlen($state) . ' / ' . $component->getMaxLength())
                                        ->maxLength(160)
                                        ->reactive()
                                        ->extraAttributes(['class' => 'meta_description']),
                                ])->columnSpan(6),
                        ])->columnSpan(6)

                ])->columns(12)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListWebsites::route('/'),
            'create' => Pages\CreateWebsite::route('/create'),
            'edit' => Pages\EditWebsite::route('/{record}/edit'),
        ];
    }
}