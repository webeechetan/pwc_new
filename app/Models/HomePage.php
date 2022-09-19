<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePage extends Model
{
    use HasFactory;
    protected $table = 'homepage';
    protected $fillable = [
        'banner_title',
        'banner_caption1',
        'banner_caption2',
        'banner_subtitle',
        'banner_button',
        'banner_button_action',
        's1_count1',
        's1_heading1',
        's1_count2',
        's1_heading2',
        's1_count3',
        's1_heading3',
        's1_count4',
        's1_heading4',
        's2_heading',
        's2_title',
        's2_description',
        's3_heading',
        's3_title',
        's3_description',
        's3_email',
        's3_contact_heading',
        's3_contact_subheading',
        'event_title',
        'event_subtitle',
        'case_study_title',
        'case_study_subtitle'
    ];
}
