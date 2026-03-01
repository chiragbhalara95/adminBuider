<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('ui-components-demo', [
            'stats' => [
                ['label' => 'Total Revenue', 'value' => '$128,450', 'change' => '+8.4% vs last month', 'tone' => 'success'],
                ['label' => 'Active Users', 'value' => '24,892', 'change' => '+3.2% vs last week', 'tone' => 'success'],
                ['label' => 'New Orders', 'value' => '1,284', 'change' => '+1.1% today', 'tone' => 'info'],
                ['label' => 'Refund Rate', 'value' => '1.9%', 'change' => '-0.4% improvement', 'tone' => 'success'],
            ],
            'revenueChart' => [35, 44, 30, 52, 48, 60, 58, 65, 55, 68, 72, 64],
            'sources' => [
                ['name' => 'Organic Search', 'value' => 42],
                ['name' => 'Direct', 'value' => 28],
                ['name' => 'Social', 'value' => 18],
                ['name' => 'Referral', 'value' => 12],
            ],
            'activities' => [
                ['title' => 'Payment received from Acme Inc.', 'time' => '2 minutes ago', 'tag' => 'Paid', 'badge' => 'success'],
                ['title' => 'New user registered: john@company.com', 'time' => '12 minutes ago', 'tag' => 'User', 'badge' => 'primary'],
                ['title' => 'Monthly report generated', 'time' => '35 minutes ago', 'tag' => 'Report', 'badge' => 'warning'],
            ],
        ]);
    }

    public function analytics()
    {
        return view('dashboard.analytics', [
            'stats' => [
                ['label' => 'Sessions', 'value' => '184,220', 'change' => '+6.1%', 'tone' => 'success'],
                ['label' => 'Avg. Session', 'value' => '3m 24s', 'change' => '+12s', 'tone' => 'success'],
                ['label' => 'Bounce Rate', 'value' => '32.8%', 'change' => '-1.6%', 'tone' => 'success'],
                ['label' => 'Conversions', 'value' => '4.2%', 'change' => '+0.7%', 'tone' => 'info'],
            ],
            'sessionsChart' => [30, 36, 42, 39, 48, 52, 58, 53, 60, 66, 62, 70],
            'channels' => [
                ['name' => 'Organic', 'value' => 39],
                ['name' => 'Paid Search', 'value' => 25],
                ['name' => 'Social', 'value' => 21],
                ['name' => 'Email', 'value' => 15],
            ],
        ]);
    }

    public function marketing()
    {
        return view('dashboard.marketing', [
            'stats' => [
                ['label' => 'Ad Spend', 'value' => '$42,800', 'change' => '+4.9%', 'tone' => 'warning'],
                ['label' => 'Leads', 'value' => '3,240', 'change' => '+9.1%', 'tone' => 'success'],
                ['label' => 'CPL', 'value' => '$13.21', 'change' => '-2.3%', 'tone' => 'success'],
                ['label' => 'ROAS', 'value' => '3.9x', 'change' => '+0.4x', 'tone' => 'success'],
            ],
            'campaigns' => [
                ['name' => 'Spring Launch', 'spend' => '$12,400', 'revenue' => '$31,500', 'roi' => 154],
                ['name' => 'Brand Awareness', 'spend' => '$8,900', 'revenue' => '$14,300', 'roi' => 61],
                ['name' => 'Retargeting', 'spend' => '$6,500', 'revenue' => '$19,100', 'roi' => 194],
            ],
            'funnel' => [
                ['name' => 'Impressions', 'value' => '1.2M', 'percent' => 100],
                ['name' => 'Clicks', 'value' => '95K', 'percent' => 62],
                ['name' => 'Leads', 'value' => '11.4K', 'percent' => 38],
                ['name' => 'Customers', 'value' => '1.8K', 'percent' => 21],
            ],
        ]);
    }

    public function crm()
    {
        return view('dashboard.crm', [
            'stats' => [
                ['label' => 'Open Leads', 'value' => '1,124', 'change' => '+5.2%', 'tone' => 'info'],
                ['label' => 'Qualified', 'value' => '486', 'change' => '+2.8%', 'tone' => 'success'],
                ['label' => 'Win Rate', 'value' => '29.4%', 'change' => '+1.3%', 'tone' => 'success'],
                ['label' => 'Avg. Deal', 'value' => '$14,200', 'change' => '-0.8%', 'tone' => 'warning'],
            ],
            'pipeline' => [
                ['name' => 'Discovery', 'count' => 214, 'value' => '$1.2M'],
                ['name' => 'Proposal', 'count' => 146, 'value' => '$980K'],
                ['name' => 'Negotiation', 'count' => 88, 'value' => '$760K'],
                ['name' => 'Closed Won', 'count' => 42, 'value' => '$540K'],
            ],
            'salesReps' => [
                ['name' => 'Olivia Martin', 'deals' => 12, 'amount' => '$184K'],
                ['name' => 'Noah Clark', 'deals' => 9, 'amount' => '$142K'],
                ['name' => 'Emma Rivera', 'deals' => 8, 'amount' => '$131K'],
            ],
        ]);
    }

    public function stocks()
    {
        return view('dashboard.stocks', [
            'stats' => [
                ['label' => 'Portfolio Value', 'value' => '$248,990', 'change' => '+2.4% today', 'tone' => 'success'],
                ['label' => 'Day Gain', 'value' => '+$5,842', 'change' => '+2.4%', 'tone' => 'success'],
                ['label' => 'Open Positions', 'value' => '18', 'change' => '2 new this week', 'tone' => 'info'],
                ['label' => 'Risk Score', 'value' => 'Moderate', 'change' => 'Stable', 'tone' => 'warning'],
            ],
            'watchlist' => [
                ['symbol' => 'AAPL', 'name' => 'Apple Inc.', 'price' => '$213.40', 'change' => '+1.12%', 'up' => true],
                ['symbol' => 'MSFT', 'name' => 'Microsoft Corp.', 'price' => '$466.12', 'change' => '+0.67%', 'up' => true],
                ['symbol' => 'TSLA', 'name' => 'Tesla Inc.', 'price' => '$182.54', 'change' => '-1.98%', 'up' => false],
                ['symbol' => 'NVDA', 'name' => 'NVIDIA Corp.', 'price' => '$132.08', 'change' => '+2.15%', 'up' => true],
            ],
            'allocation' => [
                ['sector' => 'Technology', 'value' => 52],
                ['sector' => 'Healthcare', 'value' => 18],
                ['sector' => 'Energy', 'value' => 14],
                ['sector' => 'Consumer', 'value' => 16],
            ],
        ]);
    }

    public function saas()
    {
        return view('dashboard.saas', [
            'stats' => [
                ['label' => 'MRR', 'value' => '$96,420', 'change' => '+7.8%', 'tone' => 'success'],
                ['label' => 'ARR', 'value' => '$1.15M', 'change' => '+6.9%', 'tone' => 'success'],
                ['label' => 'Churn', 'value' => '2.1%', 'change' => '-0.4%', 'tone' => 'success'],
                ['label' => 'LTV', 'value' => '$2,840', 'change' => '+3.0%', 'tone' => 'info'],
            ],
            'mrrChart' => [28, 30, 35, 38, 42, 45, 51, 55, 58, 62, 68, 72],
            'plans' => [
                ['name' => 'Starter', 'count' => 412],
                ['name' => 'Growth', 'count' => 286],
                ['name' => 'Business', 'count' => 129],
                ['name' => 'Enterprise', 'count' => 34],
            ],
        ]);
    }

    public function logistics()
    {
        return view('dashboard.logistics', [
            'stats' => [
                ['label' => 'Active Shipments', 'value' => '1,284', 'change' => '+4.1%', 'tone' => 'info'],
                ['label' => 'On-time Delivery', 'value' => '94.6%', 'change' => '+1.2%', 'tone' => 'success'],
                ['label' => 'Fleet Utilization', 'value' => '82%', 'change' => '+3.8%', 'tone' => 'success'],
                ['label' => 'Delayed Orders', 'value' => '43', 'change' => '-5 today', 'tone' => 'success'],
            ],
            'shipments' => [
                ['id' => 'A2394', 'route' => 'Los Angeles -> Seattle', 'eta' => '6h 20m', 'progress' => 74],
                ['id' => 'B1128', 'route' => 'Dallas -> Denver', 'eta' => '3h 05m', 'progress' => 58],
                ['id' => 'C9081', 'route' => 'Chicago -> Boston', 'eta' => '9h 40m', 'progress' => 41],
                ['id' => 'D7740', 'route' => 'Miami -> Atlanta', 'eta' => '1h 50m', 'progress' => 87],
            ],
            'warehouses' => [
                ['name' => 'West Hub', 'load' => 76],
                ['name' => 'Central Hub', 'load' => 69],
                ['name' => 'East Hub', 'load' => 84],
            ],
        ]);
    }

    public function profile()
    {
        $profile = [
            'name' => 'Musharof Chowdhury',
            'role' => 'Team Manager',
            'location' => 'Arizona, United States',
            'avatar' => 'https://i.pravatar.cc/160?img=12',
            'socials' => ['facebook', 'x', 'linkedin', 'instagram'],
        ];

        $personalInformation = [
            'First Name' => 'Musharof',
            'Last Name' => 'Chowdhury',
            'Email Address' => 'randomuser@pimjo.com',
            'Phone' => '+09 363 398 46',
            'Bio' => 'Team Manager',
        ];

        $address = [
            'Country' => 'United States',
            'City/State' => 'Arizona, United States',
            'Postal Code' => 'ERT 2489',
            'Tax ID' => 'AS4568384',
        ];

        return view('profile', compact('profile', 'personalInformation', 'address'));
    }
}

