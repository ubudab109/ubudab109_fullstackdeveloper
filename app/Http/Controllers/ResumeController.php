<?php

namespace App\Http\Controllers;

use App\Repositories\UserResume\UserResumeInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResumeController extends Controller
{
  /**
   * Attribute instance in this controller
   * 
   * @var mixed
   */
  public $userResume;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct(UserResumeInterface $userResume)
  {
    $this->userResume = $userResume;
  }

  
  /**
   * Get Resume Current User 
   * 
   * @return JsonResponse
   */
  public function index(): JsonResponse
  {
    return $this->sendResponse($this->userResume->getResume(Auth::user()->id), 'Data Fetched Successfully');
  }

  /**
   * Detail Resume Experience For Current User by Experience ID
   * @param int $experienceId - ID From data experience
   * @return JsonResponse
   */
  public function show(int $experienceId): JsonResponse
  {
    return $this->sendResponse($this->userResume->detailResume($experienceId), 'Data Fetched Successfully');
  }

  /**
   * Create Resume Experience For Current User 
   * @param Request
   * @return JsonResponse
   */
  public function store(Request $request): JsonResponse
  {
    $validate = Validator::make($request->all(), [
      'start_date'        => 'required',
      'end_date'          => '',
      'job_title'         => 'required',
      'company'           => 'required',
      'company_logo'      => 'file|mimes:jpeg,jpg,png|max:2048',
      'job_description'   => ''
    ]);

    if ($validate->fails()) return $this->sendBadRequest('Validator Error', $validate->fails());

    $input = $request->all();
    $input['user_id'] = Auth::user()->id;

    /* IF REQUEST FILES COMPANY LOGO */
    if ($request->hasFile('company_logo')) {
      $uploaded = $request->file('company_logo');
      $fileName = $uploaded->getClientOriginalName();
      $uploaded->move(public_path('uploads/company-logo'), time().$fileName);
      $input['company_logo'] = time().$fileName;
    }

    DB::beginTransaction();
    try {
      $experience = $this->userResume->createExperience($input);
      DB::commit();
      return $this->sendResponse($experience, 'Data Created Successfully');
    } catch (\Exception $err) {
      DB::rollBack();
      return $this->sendError('Error', 'Internal Server Error');
    }
  }

  /**
   * Update Resume Experience For Current User by Experience ID
   * @param int $experienceId - ID From data experience
   * @param Request
   * @return JsonResponse
   */
  public function update(int $experienceId, Request $request): JsonResponse
  {
    $validate = Validator::make($request->all(), [
      'start_date'        => 'required',
      'end_date'          => '',
      'job_title'         => 'required',
      'company'           => 'required',
      'company_logo'      => 'mimes:jpeg,jpg,png|max:2048',
      'job_description'   => ''
    ]);

    if ($validate->fails()) return $this->sendBadRequest('Validator Error', $validate->fails());

    $oldExperience = $this->userResume->detailResume($experienceId);
    $input = $request->all();
    $input['user_id'] = Auth::user()->id;

    /* IF REQUEST FILES COMPANY LOGO */
    if ($request->hasFile('company_logo')) {
      unlink(public_path('uploads/company-logo/').$oldExperience->company_logo);
      $uploaded = $request->file('company_logo');
      $fileName = $uploaded->getClientOriginalName();
      $uploaded->move(public_path('uploads/company-logo'), time().$fileName);
      $input['company_logo'] = time().$fileName;
    }

    $experience = $this->userResume->updateExperience($experienceId, $input);

    return $this->sendResponse($experience, 'Data Updated Successfully');
  }

  /**
   * Delete Resume Experience For Current User by Experience ID
   * @param int $experienceId - ID From data experience
   * @return JsonResponse
   */
  public function destroy(int $experienceId): JsonResponse
  {
    return $this->sendResponse($this->userResume->deleteExperience($experienceId), 'Data Deleted Successfully');
  }
}
