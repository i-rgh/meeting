<?php

namespace App\Http\Controllers\Api;

use App\Events\JoinUserToRoom;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Room\CreateRoomRequest;
use App\Http\Requests\Api\Room\JoinRequest;
use App\Http\Resources\MyRoomsResource;
use App\Http\Resources\RoomResource;
use App\Models\Participant;
use App\Models\Room;
use Illuminate\Http\Request;
use Throwable;

class RoomController extends Controller
{
    /**
     * user can create room
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateRoomRequest $request)
    {
        $room =  Room::create([
            'creator_id' => auth()->user()->id,
            'name'       => $request->name,
            'code'       => Room::generateCode(),
        ]);

        return new RoomResource($room);
    }

    /**
     * join to room
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function join(JoinRequest $request)
    {
        $room =  Room::getRoomBaseCode($request->room_code);

        Participant::create([
            'user_id' => auth()->user()->id,
            'room_id' => $room->id,
        ]);
        event(new JoinUserToRoom($room));
        $message = ['message' => 'با موفقیت به اتاق اضافه شدید'];
        return response($message, 200);
    }

    /**
     * show user rooms
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $res = auth()->user()->rooms()->with('user')->paginate(15);
        return  new MyRoomsResource($res);
    }
}
