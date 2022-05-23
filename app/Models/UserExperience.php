<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserExperience extends Model
{

  /**
   * Represent from table
   * 
   * @var string
   */
  protected $table = 'user_experience';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'user_id',
    'start_date',
    'end_date',
    'job_title',
    'company',
    'company_logo',
    'job_description'
  ];


  /**
   * The extended attributes includid to the model's JSON.
   *
   * @var array
   */
  protected $appends = [
    'is_current',
    'url_logo',
  ];

  /**
   * Get Value Attribute for 'url_logo'
   * 
   * @return string
   */
  public function getUrlLogoAttribute(): string
  {
    if ($this->company_logo != null) {
      return url('uploads/company-logo/' . $this->company_logo);
    }
    return '';
  }

  /**
   * Get Value Attribute for 'is_current'
   * 
   * @return bool
   */
  public function getIsCurrentAttribute(): bool
  {
    if ($this->end_date == null) {
      return true;
    }
    return false;
  }

  /**
   * Relation to user model
   * 
   * @return BelongsTo
   */
  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
