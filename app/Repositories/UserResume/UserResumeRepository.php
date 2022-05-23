<?php

namespace App\Repositories\UserResume;

use App\Models\User;
use App\Models\UserExperience;

class UserResumeRepository implements UserResumeInterface
{
  /**
   * @var ModelName
   */
  protected $user, $experience;

  public function __construct(User $user, UserExperience $experience)
  {
    $this->user = $user;
    $this->experience = $experience;
  }

  /**
   * Get Resume by current user id
   * 
   * @param int $userId - User ID
   * @return object
   */
  public function getResume(int $userId): object
  {
    return $this->user->with('experience')->findOrFail($userId);
  }

  /**
   * Detail Experience Resume by experience ID
   * 
   * @param int $experienceId - Experience ID from current user
   * @return object
   */
  public function detailResume(int $experienceId): object
  {
    return $this->experience->with('user')->findOrFail($experienceId);
  }

  /**
   * Create Experience Resume by current user id
   * 
   * @param array $experienceData - Input data for experience
   * @return object
   */
  public function createExperience(array $experienceData): object
  {

    $experience = $this->experience->create($experienceData);

    return $experience;
  }

  /**
   * Update Experience Resume by experience ID
   * 
   * @param int $experienceId - Experience ID from current user
   * @param array $experienceData - Input data for experience
   * @return object
   */
  public function updateExperience(int $experienceId, array $experienceData): object
  {
    $experience = $this->experience->findOrFail($experienceId);

    $experience->update($experienceData);

    return $experience;
  }

  /**
   * Delete Experience Resume by experience ID
   * 
   * @param int $experienceId - Experience ID from current user
   * @return bool
   */
  public function deleteExperience(int $experienceId): bool
  {
    return $this->experience->findOrFail($experienceId)->delete();
  }
}
