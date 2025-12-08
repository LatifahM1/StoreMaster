<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str; // ✅ أضف هذا في الأعلى

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token', // ✅ أضف هذا
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // ✅ أضف هذه الدالة داخل الـ class
    public function createToken($name)
    {
        $token = Str::random(60);
        
        $this->api_token = hash('sha256', $token);
        $this->save();
        
        // إرجاع كائن يحتوي على التوكن
        return new class($token) {
            protected $plainTextToken;
            
            public function __construct($plainTextToken)
            {
                $this->plainTextToken = $plainTextToken;
            }
            
            public function plainTextToken()
            {
                return $this->plainTextToken;
            }
        };
    }
}