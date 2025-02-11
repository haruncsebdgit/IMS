@if('bn' === config('app.locale'))
 <style>
     body {
        font-family: 'bangla', ind_bn_1_001, sans-serif;
    }
 </style>
@endif
<style>
    small, .small {
        font-size: 80%;
        font-weight: 400;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-report tr th,
    .table-report tr td {
        border: 1px solid #000;
        padding: 2px;
    }

    .font-weight-bold,
    .table-report tr th {
        font-weight: bold;
    }

    .text-center {
        text-align: center !important;
    }

    .text-left {
        text-align: left !important;
    }

    .text-right {
        text-align: right !important;
    }

    .d-inline-block {
        display: inline-block;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .mt-5 {
        margin-top: 3rem !important;
    }
</style>
