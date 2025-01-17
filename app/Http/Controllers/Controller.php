<?php

namespace App\Http\Controllers;
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Post API",
 *      description="This is a sample API documentation for a project.",
 *      @OA\Contact(
 *          email="developer@example.com"
 *      )
 * )
 *
 * @OA\Server(
 *      url="/api",
 *      description="API Server"
 * )
 * 
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 *      description="Enter your bearer token in the format 'Bearer {token}'"
 * )
 */

abstract class Controller
{
    //
}
