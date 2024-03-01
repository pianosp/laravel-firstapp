<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // protected $fillable = ['title','company','location','website','email','description','tag'];
    //สร้างการอนุญาติสำหรับให้ input ข้อมูลเหล่านี้เข้า database ได้ หรือ เพิ่ม 'Model::unguard' ใน AppServiceProvider boot()

    public function scopeFilter($query, array $filters){
        if($filters['tag'] ?? false){
            //ถ้ามี request tag จาก query string ให้ทำ
            $query->where('tag' , 'like', '%' . request('tag') . '%'); //หาค่าใน tag column ที่ตรงกับ request จาก tag
        }

        if($filters['search'] ?? false){
            //ถ้ามี request search จาก query string ให้ทำ
            $query->where('title' , 'like', '%' . request('search') . '%') //หาค่าใน title column ที่ตรงกับ request จาก search
            ->orwhere('description' , 'like', '%' . request('search') . '%') //หาค่าใน description column ที่ตรงกับ request search
            ->orwhere('tag' , 'like', '%' . request('search') . '%'); //หาค่าใน tag column ที่ตรงกับ request search
        }
    }


    //Relationship To User
    public function user(){
        return $this->belongsTo(User::class, 'user_id'); //คือ Listing:1 -> User:1
    }
}
