<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Currency Rates</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .title {
            margin-top: 48px;
        }

        .section {
            margin: 32px 0px;
        }

        .component {
            margin-bottom: 16px;
        }

        .warning {
            margin-top: 32px;
            color: #888;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="title">Currency Rates</h1>
        <form class="section" method="GET">
            <div class="form-group component">
                <label for="base">Base Currency</label>
                <input type="text" name="base" class="form-control" value="{{ $data->filter->base }}" id="base">
            </div>
            <div class="form-group component">
                <label for="target">Target Currency</label>
                <input type="text" name="target" class="form-control" value="{{ $data->filter->target }}" id="target">
            </div>
            <div class="form-group component">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-control" value="{{ $data->filter->date }}" id="date">
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
        @if (count($data->rates) > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Base</th>
                        <th>Target</th>
                        <th>Rate</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data->rates as $rate)
                        <tr>
                            <td>{{ $rate->base }}</td>
                            <td>{{ $rate->target }}</td>
                            <td>{{ number_format($rate->rate, 4) }}</td>
                            <td>{{ $rate->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="warning">
                <h3>No Data Available</h3>
                <p>There are no currency rates available for the selected filters.</p>
                <a href="/" class="btn btn-secondary ms-2">Clear Filters</a>
            </div>
        @endif
    </div>
</body>

</html>