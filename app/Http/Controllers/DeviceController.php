<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class DeviceController extends Controller
{
    public function createNewDevice(Request $request) {
        try {
            $deviceObj = new Device;
            $deviceObj->espname = $request->input("data.espname");
            $deviceObj->password = Hash::make("Smarthelper");
            $deviceObj->deviceid = $request->input("data.deviceid");

            $deviceObj->save();
            
            return response()->json([
                'message' => 'Device create completed',
                'data' => [
                    'espname' => $request->input("data.espname"), 
                    'deviceid' => $request->input("data.deviceid")
                ]
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Device create not completed'
            ], 400);
        }
    }

    public function checkDeviceByESPName(Request $request) {
        $deviceObj = new Device;
        $device = $deviceObj->where('espname', $request->input('data.espname'))->first();
        if ($device) {
            return response()->json([
                'message' => 'Found device',
                'data' => $device->toArray()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found device'
            ], 404);
        }
    }

    public function checkDeviceByDeviceID(Request $request) {
        $deviceObj = new Device;
        $device = $deviceObj->where('deviceid', $request->input('data.deviceid'))->first();
        if ($device) {
            return response()->json([
                'message' => 'Found device',
                'data' => $device->toArray()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not found device'
            ], 404);
        }
    }

    public function updateDeviceByESPName(Request $request) {
        $deviceObj = new Device;
        $device = $deviceObj->where('espname', $request->input('data.espname'))->first();
        if ($device) {
            $device->password = Hash::make($request->input('data.password'));
            $device->save();
            return response()->json([
                'message' => 'Device update complete'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Device update not complete'
            ], 404);
        }
    }
}
