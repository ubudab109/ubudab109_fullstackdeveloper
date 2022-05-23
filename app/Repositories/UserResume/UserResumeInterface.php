<?php

namespace App\Repositories\UserResume;

interface UserResumeInterface
{
  /**
   * Get Resume by current user id
   * 
   * @param int $userId - User ID
   * @return object
   */
  public function getResume(int $userId): object;

  /**
   * Detail Experience Resume by experience ID
   * 
   * @param int $experienceId - Experience ID from current user
   * @return object
   */
  public function detailResume(int $experienceId): object;

  /**
   * Create Experience Resume by current user id
   * 
   * @param array $experienceData - Input data for experience
   * @return object
   */
  public function createExperience(array $experienceData): object;

  /**
   * Update Experience Resume by experience ID
   * 
   * @param int $experienceId - Experience ID from current user
   * @param array $experienceData - Input data for experience
   * @return object
   */
  public function updateExperience(int $experienceId, array $experienceData): object;

  /**
   * Delete Experience Resume by experience ID
   * 
   * @param int $experienceId - Experience ID from current user
   * @return bool
   */
  public function deleteExperience(int $experienceId): bool;
}
