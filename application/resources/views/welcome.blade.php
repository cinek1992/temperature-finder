<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
{{--    <link rel="stylesheet" href="{{url('css/app.css')}}">--}}
    <style>
        {{file_get_contents(base_path('/public/css/app.css'))}}
    </style>
</head>
<body>
<div class="container">
    <h3>Temperature finder</h3>
    <div class="col-lg-6 offset-lg-3">
        <form method="POST">
            {{csrf_field()}}
            <div>
                <label>Country</label>
                <input type="text" name="country" class="form-control" value="{{old('country') ?? $country}}"/>
                @if($errors->has('country'))
                    <label class="error">{{$errors->first('country')}}</label>
                @endif
            </div>
            <div>
                <label for="city">City</label>
                <input type="text" id="city" name="city" class="form-control" value="{{old('city') ?? $city}}"/>
                @if($errors->has('city'))
                    <label class="error">{{$errors->first('city')}}</label>
                @endif
            </div>
            <div>
                <label for="city">Temperature type</label>
                <select name="type" class="form-control">
                    @foreach($temperatureTypes as $temperatureType)
                        <option
                            value="{{$temperatureType}}" {{(old('type') ? $temperatureType === old('type') : $type === $temperatureType) ? 'selected' : ''}}>
                            {{trans('temperature.' . $temperatureType)}}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <label class="error">{{$errors->first('type')}}</label>
                @endif
            </div>
            <div>
                <button type="submit" class="btn btn-success">Show temperature</button>
            </div>
        </form>
    </div>

    @isset($temperature)
        <p>Temperature for country <b>{{request('country')}}</b> and city <b>{{request('city')}}</b> is {{$temperature}}
            <span>&#176;</span>{{ucfirst($type[0])}}</p>
    @endisset
    @if($missing)
        <p>Sorry, we have no data about temperature in country <b>{{request('country')}}</b> and city <b>{{request('city')}}</b> </p>
    @endif
    <footer>
        Powered by:
        <ul>
            @foreach($services as $service)
                <li><a href="{{$service->getServiceUrl()}}" target="_blank">{{$service->getServiceName()}}</a></li>
            @endforeach
        </ul>
    </footer>
</div>
</body>
</html>
