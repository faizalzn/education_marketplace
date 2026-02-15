<?php

namespace App\Filament\Resources;

use App\Models\UserKyc;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserKycResource extends Resource
{
    protected static ?string $model = UserKyc::class;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationLabel = 'KYC Verification';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->schema([
                        Forms\Components\TextInput::make('full_name')->required(),
                        Forms\Components\TextInput::make('phone_number')->required(),
                        Forms\Components\DatePicker::make('date_of_birth')->required(),
                        Forms\Components\Select::make('gender')
                            ->options(['male' => 'Male', 'female' => 'Female', 'other' => 'Other']),
                    ]),
                
                Forms\Components\Section::make('Address')
                    ->schema([
                        Forms\Components\TextInput::make('street_address')->required(),
                        Forms\Components\TextInput::make('city')->required(),
                        Forms\Components\TextInput::make('state')->required(),
                        Forms\Components\TextInput::make('postal_code')->required(),
                        Forms\Components\TextInput::make('country')->required(),
                    ]),
                
                Forms\Components\Section::make('Identity Verification')
                    ->schema([
                        Forms\Components\Select::make('id_type')
                            ->options(['passport' => 'Passport', 'national_id' => 'National ID', 'driver_license' => 'Driver License'])
                            ->required(),
                        Forms\Components\TextInput::make('id_number')->required(),
                        Forms\Components\DatePicker::make('id_expiry_date')->required(),
                    ]),
                
                Forms\Components\Section::make('Bank Details')
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')->required(),
                        Forms\Components\TextInput::make('bank_account_number')->required(),
                        Forms\Components\TextInput::make('bank_account_holder_name')->required(),
                    ]),
                
                Forms\Components\Section::make('Verification Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'under_review' => 'Under Review',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required(),
                        
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Rejection Reason')
                            ->visible(fn($get) => $get('status') === 'rejected'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'under_review',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'under_review' => 'Under Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->visible(fn(UserKyc $record) => !$record->isApproved())
                    ->action(fn(UserKyc $record) => $record->approve()),
                
                Tables\Actions\Action::make('reject')
                    ->visible(fn(UserKyc $record) => !$record->isRejected())
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->required(),
                    ])
                    ->action(fn(UserKyc $record, array $data) => $record->reject($data['rejection_reason'])),
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
            'index' => ListUserKycs::route('/'),
            'view' => ViewUserKyc::route('/{record}'),
            'edit' => EditUserKyc::route('/{record}/edit'),
        ];
    }
}
