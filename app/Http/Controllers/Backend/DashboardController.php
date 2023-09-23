<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Role;
use Carbon\Carbon;

class DashboardController extends Controller
{
	public function index_phpinfo()
	{
		$laravel = app();
		echo 'Curl: ', function_exists('curl_version') ? 'Enabled' . "\xA" : 'Disabled' . "\xA";
		echo ' || Laravel Version is : ' . $laravel::VERSION;
		phpinfo();
		exit;
	}

	public function index()
	{
		$role_id = session('data')['role_id'];
		$user_id = session('data')['id'];

		//for admin
		if ($role_id == 1) {
			return $this->adminDashboard();
		}
		elseif ($role_id == 2) { // for staff
			return $this->staffDashboard($user_id);
		}
		else { // for genericDashboard
			return $this->genericDashboard();
		}
	}

	private function genericDashboard(){
		$dashboard_view = 'index';
		// added by Arjun singh
		$data['total_staff'] = Admin::where([['admins.role_id', 2]])->count();
		$data['total_products'] = Product::all()->count();
		$data['total_clients'] = Client::all()->count();
		$data['total_certificate'] = Certificate::all()->count();
		$data['todayExpiring_certificates'] = Certificate::where([['certificates.next_calibration_date', '<=', date('Y-m-d')]])->count();
		$data['todays_certificates'] = Certificate::where([['certificates.calibration_date', '>=', date('Y-m-d')]])->count();
		$data['expired_certificate'] = Certificate::where([['certificates.next_calibration_date', '<', date('Y-m-d')]])->count();
		$data['updated_product'] = Product::where([['products.updated_at', '>=', date('Y-m-d')]])->count();
		//ended by arjun

		return view('backend/dashboard/' . $dashboard_view,  $data);
	}

	private function staffDashboard($user_id)
	{
		$dashboard_view = 'staff_dashboard';
		// added by Arjun singh
		$data['total_staff'] = Admin::where([['admins.role_id', 2]])->count();
		$data['total_products'] = Product::all()->count();
		$data['total_clients'] = Client::all()->count();
		$data['total_certificate'] = Certificate::all()->count();
		//ended by arjun
		return view('backend/dashboard/' . $dashboard_view,  $data);
	}

	private function adminDashboard()
	{
		$dashboard_view = 'admin_dashboard';
		// added by Arjun singh
		$data['total_staff'] = Admin::where([['admins.role_id', 2]])->count();
		$data['total_products'] = Product::all()->count();
		$data['total_clients'] = Client::all()->count();
		$data['total_certificate'] = Certificate::all()->count();
		$data['todayExpiring_certificates'] = Certificate::where([['certificates.next_calibration_date', '<=', date('Y-m-d')]])->count();
		$data['todays_certificates'] = Certificate::where([['certificates.calibration_date', '>=', date('Y-m-d')]])->count();
		$data['expired_certificate'] = Certificate::where([['certificates.next_calibration_date', '<', date('Y-m-d')]])->count();
		$data['updated_product'] = Product::where([['products.updated_at', '>=', date('Y-m-d')]])->count();
		//ended by arjun

		return view('backend/dashboard/' . $dashboard_view,  $data);
	}

	/**
     * @author Arjun Singh <chhotelal.s@mypcot.com>
     * Created On : 29 dec 2022
     * Uses : This will load Line Chart.
     * @return array
     */
	public function certificateDashboardChart(){
		$sample = array();

		for ($i = 0; $i <= 11; $i++) {
			$date = date("M/y", strtotime(" -$i month"));
			$sample[$date]['month'] = $date;
			$sample[$date]['total'] = 0;
		}

		$data = DB::select("SELECT DATE_FORMAT(calibration_date, '%b/%y') AS month, count(*) as total
        FROM certificates
        WHERE calibration_date <= NOW()
        and calibration_date >= Date_add(Now(),interval - 12 month)
        GROUP BY DATE_FORMAT(calibration_date, '%Y-%m');");

        if (!empty($data)) {
			foreach ($data as $key => $value) {
			if (isset($sample[$value->month])) {
				$sample[$value->month]['total'] = $value->total;
				}
	        }
        }

        return array_values(array_reverse($sample));
	}
}
