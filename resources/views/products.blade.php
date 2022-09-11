<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <title>Php nadsenec</title>
    <link href="{{ asset('app.css') }}" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <section id="price">
        <div class="content">
            <h1 class="bold">Our products</h1>
            <form method="POST" action="/create">
                @csrf
                <table id="table">
                    <thead>
                        <tr>
                            <th data-col="name">Name
                                <x-vaadin-sort />
                            </th>
                            <th>Short Description</th>
                            <th data-col="stock">OnStock
                                <x-vaadin-sort />
                            </th>
                            <th>PictureMain</th>
                            <th data-col="weight">Weight
                                <x-vaadin-sort />
                            </th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="table">
                        @foreach($itemsXML as $item)
                        <tr id="{{$item->id}}">
                            <td><strong>{{$item->name}}</strong></td>
                            <td>{!! $item->desc !!}</td>
                            @if ($item->onStock == 'true')
                            <td class="iconRowOK">
                                <x-elusive-ok-sign />
                            </td>
                            @else
                            <td class="iconRowX">
                                <x-tni-x-circle />
                            </td>
                            @endif
                            <td><img src="{{$item->img}}" alt="ItemPic"></td>
                            <td>{{$item->weight}}</td>
                            <td><input type="hidden" name="products[]" value="{{$item->id}}" /><input type="number" name="quantity[]" class="form-control" min="0" max="1000" placeholder="ks" pattern="\d*"></input></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="buttonWrapper">
                    <input id="orderButton" type="submit" value="Ulozit objednavku">
                </div>
            </form>
        </div>
    </section>
</body>
<script src="{{ asset('app.js')}}"></script>

</html>