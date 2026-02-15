<?php

namespace App\Filament\Resources;

use App\Models\Settlement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettlementResource extends Resource
{
    protected static ?string $model = Settlement::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Settlements';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Settlement Information')
                    ->schema([
                        Forms\Components\TextInput::make('settlement_reference')
                            ->disabled()
                            ->dehydrated(),
                        
                        Forms\Components\Select::make('instructor_id')
                            ->relationship('instructor', 'name')
                            ->required()
                            ->disabled()
                            ->dehydrated(),
                        
                        Forms\Components\Select::make('period')
                            ->options(['weekly' => 'Weekly', 'biweekly' => 'Bi-weekly', 'monthly' => 'Monthly'])
                            ->required(),
                        
                        Forms\Components\DatePicker::make('period_start')->required(),
                        Forms\Components\DatePicker::make('period_end')->required(),
                    ]),
                
                Forms\Components\Section::make('Financial Summary')
                    ->schema([
                        Forms\Components\TextInput::make('total_bookings_amount')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),
                        
                        Forms\Components\TextInput::make('platform_commission')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),
                        
                        Forms\Components\TextInput::make('net_amount')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),
                        
                        Forms\Components\TextInput::make('refund_amount')
                            ->numeric(),
                        
                        Forms\Components\TextInput::make('final_amount')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(),
                    ]),
                
                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approved',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),
                        
                        Forms\Components\Textarea::make('rejection_reason')
                            ->visible(fn($get) => $get('status') === 'rejected'),
                        
                        Forms\Components\Textarea::make('notes'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('settlement_reference')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('instructor.name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('period_start')
                    ->date(),
                
                Tables\Columns\TextColumn::make('final_amount')
                    ->money('USD'),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'approved',
                        'default' => 'processing',
                        'success' => 'completed',
                        'danger' => 'rejected',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->visible(fn(Settlement $record) => $record->isPending())
                    ->action(fn(Settlement $record) => $record->approve())
                    ->requiresConfirmation(),
                
                Tables\Actions\Action::make('pay')
                    ->visible(fn(Settlement $record) => $record->isApproved())
                    ->action(fn(Settlement $record) => $record->markAsPaid())
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSettlements::route('/'),
            'view' => ViewSettlement::route('/{record}'),
            'edit' => EditSettlement::route('/{record}/edit'),
        ];
    }
}
