<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderLineItem;
use App\Models\Package;
use App\Models\Session;
use App\Models\SessionOrderItem;
use Illuminate\Http\Request;


class SessionController extends Controller
{
    public function index(){
        $pending_sessions=Session::where('status','pending')->get();
        $waiting_to_purchase=Session::where('status','waiting_to_purchase')->get();
        $ordered_on_sheins=Session::where('status','ordered_on_shein')->get();
        $shipped_from_sheins=Session::where('status','shipped_from_shein')->get();
        $received_in_dubai_orders=Session::where('status','received_in_dubai')->get();
        $sent_to_iraq_orders=Session::where('status','sent_to_iraq')->get();
        $fulfilled_orders=Session::where('status','fulfilled')->get();
        return view('admin.sessions.index',compact('pending_sessions','waiting_to_purchase','shipped_from_sheins','ordered_on_sheins','received_in_dubai_orders','sent_to_iraq_orders','fulfilled_orders'));
    }

    public function CreateSession(){
        // Get all line_Item_ids from OrderLineitem table
        $excludedLineItemIds = SessionOrderItem::pluck('lineitem_id')->toArray();

        // Fetch orders and filter line_items to exclude those with line_Item_id in excludedLineItemIds
        $orders = Order::with(['line_items' => function($query) use ($excludedLineItemIds) {
            $query->whereNotIn('id', $excludedLineItemIds);
        }])->get();

        return view('admin.sessions.create_session', compact('orders'));
    }

    public function SaveSession(Request $request){
        $total_price=0;

        $latestSession = Session::latest('session_id')->first();

        $sessionNumber = $latestSession ? substr($latestSession->session_id, 1) + 1 : 1;

        // Format the session number to have leading zeros (e.g., #01, #02, etc.)
        $formattedSessionId = '#' . str_pad($sessionNumber, 2, '0', STR_PAD_LEFT);
        $session=new Session();
        $session->session_id=$formattedSessionId;
        $session->status='pending';
        $session->no_of_items=count($request->selected_items);
        $session->save();
        foreach ($request->selected_items as $item_id){
            $line_item=OrderLineItem::find($item_id);
            if($line_item){
                $total_price +=$line_item->price * $line_item->quantity;

                $session_order_item=new SessionOrderItem();
                $session_order_item->session_id=$session->id;
                $session_order_item->order_id=$line_item->order_id;
                $session_order_item->lineitem_id=$item_id;
                $session_order_item->save();
            }

        }

        $session->total_price=$total_price;
        $session->save();

        return redirect()->route('sessions')->with('success','Session created Successfully');

    }

    public function DeleteSession($id){
        $session=Session::find($id);
        if($session){
            SessionOrderItem::where('session_id',$id)->delete();
            $session->delete();
            return redirect()->route('sessions')->with('success','Session deleted Successfully');
        }
    }

    public function ViewSession($id)
    {
        $session = Session::find($id);

        if ($session) {
            // Retrieve session order items for the given session ID
            $session_order_items = SessionOrderItem::where('session_id', $session->id)->get();

            // Collect order IDs and line item IDs from session order items
            $orderIds = $session_order_items->pluck('order_id')->unique();
            $lineItemIds = $session_order_items->pluck('lineitem_id')->unique();

            // Retrieve orders with only the specified line items
            $orders = Order::whereIn('id', $orderIds)
                ->with(['line_items' => function ($query) use ($lineItemIds) {
                    $query->whereIn('id', $lineItemIds);
                }])
                ->get();


             $packages=Package::where('session_id',$id)->get();

            return view('admin.sessions.session_details', compact('session', 'orders','packages'));
        }

    }

    public function updateStatus(Request $request, $id)
    {
        $session = Session::findOrFail($id);
        $session->status = $request->status;
        $session->save();
        return response()->json(['success' => true]);
    }

    public function SessionDetailUpdate(Request $request,$id){
        $session = Session::findOrFail($id);
        $session->session_link = $request->session_link;
        $session->shein_account = $request->shein_account;
        $session->save();

        return redirect()->route('view_session', $session->id)
            ->with('success', 'Details updated successfully');
    }


}