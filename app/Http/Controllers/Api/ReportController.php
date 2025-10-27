<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\BukuDigital;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function monthlyMemberReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $members = Anggota::whereMonth('tanggal_bergabung', $month)
            ->whereYear('tanggal_bergabung', $year)
            ->get();

        $totalNewMembers = $members->count();
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'month' => $month,
                'year' => $year,
                'total_new_members' => $totalNewMembers,
                'members' => $members
            ]
        ]);
    }

    public function monthlyDigitalBookReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $books = BukuDigital::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        $totalNewBooks = $books->count();
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'month' => $month,
                'year' => $year,
                'total_new_books' => $totalNewBooks,
                'books' => $books
            ]
        ]);
    }

    public function monthlyActivityReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        // Get borrowing statistics
        $borrowingStats = Peminjaman::whereMonth('tanggal_pinjam', $month)
            ->whereYear('tanggal_pinjam', $year)
            ->select(
                DB::raw('COUNT(*) as total_peminjaman'),
                DB::raw('COUNT(DISTINCT anggota_id) as total_peminjam')
            )
            ->first();

        // Get most borrowed books
        $popularBooks = Peminjaman::whereMonth('tanggal_pinjam', $month)
            ->whereYear('tanggal_pinjam', $year)
            ->select('buku_id', DB::raw('COUNT(*) as total_peminjaman'))
            ->groupBy('buku_id')
            ->orderByDesc('total_peminjaman')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'month' => $month,
                'year' => $year,
                'borrowing_statistics' => $borrowingStats,
                'popular_books' => $popularBooks
            ]
        ]);
    }

    public function combinedMonthlyReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $memberReport = $this->monthlyMemberReport($request)->original['data'];
        $bookReport = $this->monthlyDigitalBookReport($request)->original['data'];
        $activityReport = $this->monthlyActivityReport($request)->original['data'];

        return response()->json([
            'status' => 'success',
            'data' => [
                'month' => $month,
                'year' => $year,
                'member_statistics' => $memberReport,
                'book_statistics' => $bookReport,
                'activity_statistics' => $activityReport
            ]
        ]);
    }
}