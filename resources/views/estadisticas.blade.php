@extends('layouts.plantilla')

@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f7fafc;
    }
    .stats-header {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2em;
        font-weight: bold;
        color: #4a5568;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    .stats-card {
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        padding: 24px;
        text-align: center;
        transition: transform 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .stats-card h5 {
        font-size: 1.5em;
        margin-bottom: 10px;
        color: #fff;
    }
    .stats-card p {
        font-size: 1.2em;
        color: #fff;
    }
    .total-members {
        background-color: #4299e1;
    }
    .active-members {
        background-color: #48bb78;
    }
    .total-sales {
        background-color: #ed8936;
    }
    .total-purchases {
        background-color: #38b2ac;
    }
    .monthly-sales {
        background-color: #9f7aea;
    }
    .monthly-purchases {
        background-color: #e53e3e;
    }
</style>

<div class="container">
    <h1 class="stats-header">Estadísticas del Gimnasio Body Fit</h1>
    <div class="stats-grid">
        <div class="stats-card total-members">
            <h5>Total de Miembros</h5>
            <p>{{ $totalMembers }}</p>
        </div>
        <div class="stats-card active-members">
            <h5>Miembros Activos</h5>
            <p>{{ $activeMembers }}</p>
        </div>
        <div class="stats-card total-sales">
            <h5>Cantidad de Ventas Realizadas</h5>
            <p>{{ $totalSales }}</p>
        </div>
        <div class="stats-card total-purchases">
            <h5>Cantidad de Compras Realizadas</h5>
            <p>{{ $totalPurchases }}</p>
        </div>
        <div class="stats-card monthly-sales">
            <h5>Ventas Mensuales</h5>
            <p>{{ $monthlySales }}</p>
        </div>
        <div class="stats-card monthly-purchases">
            <h5>Compras Mensuales</h5>
            <p>{{ $monthlyPurchases }}</p>
        </div>
    </div>
</div>
@endsection