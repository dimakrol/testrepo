<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subscription.index');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $query = Subscription::with('user')->select('subscriptions.*');

            return Datatables::of($query)
                ->addColumn('delete', function ($subscription) {
                    return '<button class="btn btn-danger delete-subscription" data-subscription-id="'.$subscription->id.'">Delete</button>';
                })
                ->rawColumns(['delete'])
                ->make(true);
        }
        return redirect(url('/admin'));
    }

    public function addFreeSubscription($id)
    {
        $user = User::findOrFail($id);
        if (!$user->subscriptions()->count()) {
            $user->subscriptions()->create([
                'name' => 'yearly',
                'billing_type' => 'stripe',
                'stripe_id' => 'free',
                'stripe_plan' => 'yearly',
                'quantity' => 0,
                'next_payment' => Carbon::now()->addYear()
            ]);
            flash('Subscription added successfully!')->success();
            return redirect()->route('admin.user.edit', $user->id);
        }
        return back();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Subscription::destroy($id)) {
            return response()->json('success');
        }
    }
}
