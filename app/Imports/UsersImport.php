<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements 
    ToCollection, 
    WithHeadingRow, 
    WithValidation,
    SkipsOnError
{
    use Importable, SkipsErrors;
    private $rows = 0;
    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) 
        {
            ++$this->rows;
            User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'password' => Hash::make($row['password']),
                'role_id'=> $row['role_id'],
                'phone' => $row['phone'],
                'status' => $row['status'],
            ]);
        }
    }

    public function getRowCount(): int
    {
        return $this->rows;
    }

    public function rules(): array
    {
       return [
        '*.email' => ['required', 'email', 'unique:users,email'],
        '*.phone' => ['sometimes', 'nullable', 'unique:users,phone'],
        '*.password' => ['required'],
        '*.role_id' => ['required'],
        '*.status' => ['required'],
       ]; 
    }
}
