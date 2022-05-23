<?php

use App\Models\User;
use App\Models\UserExperience;
use App\Repositories\UserResume\UserResumeInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class ResumeTest extends TestCase
{

  /**
   * Can List resume experience
   * 
   * @return void
   */
  public function test_list_experience_resume()
  {

    $user = User::create([
      'name'      => 'test',
      'email'     => 'test@test.com',
      'password'  => Hash::make('123123123')
    ]);

    UserExperience::create([
      'user_id'         => $user->id,
      'start_date'      => Date::now(),
      'job_title'       => 'FE Developer',
      'company'         => 'PT YUS',
      'job_description' => 'FE Developer',
    ]);

    $this->actingAs($user, 'api')
    ->
    get('api/resume')
    ->seeJsonStructure([
      'success',
      'data' => [
        'id',
        'name',
        'age',
        'profile_picture',
        'email',
        'created_at',
        'updated_at',
        'experience'  => [
          '*' => [
            'id',
            'user_id',
            'start_date',
            'end_date',
            'job_title',
            'company',
            'company_logo',
            'job_description',
            'created_at',
            'updated_at',
            'is_current',
            'url_logo',
          ]
        ]
      ]
    ])
    ->assertResponseOk();

    return User::find($user->id)->delete();
  }

  /**
   * Can Create resume experience
   * 
   * @return void
   */
  public function test_create_exprience_resume()
  {
    $user = User::create([
      'name'      => 'test',
      'email'     => 'test@test.com',
      'password'  => Hash::make('123123123')
    ]);

    $data = [
      'user_id'         => $user->id,
      'start_date'      => Date::now(),
      'job_title'       => 'FE Developer',
      'company'         => 'PT YUS',
      'job_description' => 'FE Developer',
    ];

    $this->actingAs($user, 'api')
    ->post('api/resume', $data)
    ->assertResponseOk();
    return User::find($user->id)->delete();
  }

  /**
   * Can Update resume experience
   * 
   * @return void
   */
  public function test_update_experience_resume()
  {
    $user = User::create([
      'name'      => 'test',
      'email'     => 'test@test.com',
      'password'  => Hash::make('123123123')
    ]);

    $expr = UserExperience::create([
      'user_id'         => $user->id,
      'start_date'      => Date::now(),
      'job_title'       => 'FE Developer',
      'company'         => 'PT YUS',
      'job_description' => 'FE Developer',
    ]);

    $data = [
      'user_id'         => $user->id,
      'start_date'      => Date::now(),
      'job_title'       => 'FE Developer',
      'company'         => 'PT YUS',
      'job_description' => 'FE Developer',
    ];

    $this->actingAs($user, 'api')
    ->post('api/resume/'.$expr->id, $data)
    ->assertResponseOk();
    return User::find($user->id)->delete();
  }

  /**
   * Can Delete resume experience
   * 
   * @return void
   */
  public function test_delete_resume_experience()
  {
    $user = User::create([
      'name'      => 'test',
      'email'     => 'test@test.com',
      'password'  => Hash::make('123123123')
    ]);

    UserExperience::create([
      'id'              => 1234,
      'user_id'         => $user->id,
      'start_date'      => Date::now(),
      'job_title'       => 'FE Developer',
      'company'         => 'PT YUS',
      'job_description' => 'FE Developer',
    ]);


    $this->actingAs($user, 'api')
    ->delete('api/resume/1234', [], [])
    ->assertResponseOk();
    return User::find($user->id)->delete();
  }
}
