<?php
/**
 * Created by PhpStorm.
 * User: codeliter
 * Date: 2/5/19
 * Time: 12:14 PM
 */

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * Register a User
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        // Store the request payloads
        $first_name = $request->json('first_name') ?? '';
        $last_name = $request->json('last_name') ?? '';
        $phone = $request->json('phone') ?? 0;
        $email = $request->json('email') ?? '';
        $username = $request->json('username') ?? '';
        $password = $request->json('password') ?? '';

        // The error container
        $errors = [];

        // First name is empty
        if (strlen($first_name) == 0)
            $errors[] = "First name field is required";

        // First name is less than 3 characters
        if (strlen($first_name) > 0 && strlen($first_name) < 3)
            $errors[] = 'The first name must be at least 3 characters';

        // Last name is empty
        if (strlen($last_name) == 0)
            $errors[] = "Last name field is required";

        // Last name is less than 3 characters
        if (strlen($last_name) > 0 && strlen($first_name) < 3)
            $errors[] = 'The first name must be at least 3 characters';

        // Email is invalid
        if (strlen($email) == 0 || !filter_var($email, FILTER_VALIDATE_EMAIL))
            $errors[] = 'Please enter a valid email address';

        // Check if Email already exists in database
        if (filter_var($email, FILTER_VALIDATE_EMAIL) && Users::where('email', $username)->count() > 0)
            $errors[] = 'Please enter another email address';

        // Username is empty
        if (strlen($username) == 0)
            $errors[] = 'The username field is required';

        // Username is less than 4 characters
        if (strlen($username) > 0 && strlen($username) < 4)
            $errors[] = 'The username is too short, must be at least 4 characters';

        // Check if Username already exists in database
        if (strlen($username) > 0 && Users::where('username', $username)->count() > 0)
            $errors[] = 'Please enter another username';

        // If the phone is set and it is less than 10
        if ($phone > 0 && strlen($phone) < 10)
            $errors[] = 'Please enter a valid mobile phone number';

        // If the phone is set and already exists in the Database
        if ($phone > 0 && Users::where('phone_number', $phone)->count() > 0)
            $errors[] = 'Please enter another phone number';

        // Password is empty
        if (strlen($password) == 0)
            $errors[] = 'Password field is required';

        if (strlen($password) > 0 && strlen($password) < 6)
            $errors[] = 'Password is too short, must be at least 6 characters';

        // If the error container is not empty
        if (count($errors) > 0)
            return response()->json(['message' => 'Some data failed validation', 'data' => $errors], 400);


        // If all went well
        // Let's store this user to database
        $data = [
            'fname' => $first_name,
            'lname' => $last_name,
            'password' => password_hash(trim($password), PASSWORD_BCRYPT),
            'email' => $email,
            'username' => $username,
            'uuid' => $uuid = (string)Str::uuid(),
            'phone_number' => ($phone == 0) ? '' : $phone
        ];

        $data = array_map('trim', $data);

        // If storing of data failed
        if (!Users::create($data))
            return response()->json(['message' => 'Registration failed, Please try again!'], 400);

        return response()->json(['message' => 'Registration successful!'], 200);
    }
}