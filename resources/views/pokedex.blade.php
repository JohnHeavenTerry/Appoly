<div class="header">
    <span onclick="getPokemonFromApi()" class="addBtn">Get Pokemon Data</span>
</div>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/sass/app.scss')
</head>
<body>
<div pokeData="{{$pokeData}}" id="app">
</div>

@vite('resources/js/app.js')
</body>
</html>
<script>
    function getPokemonFromApi() {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: '/getPokemonFromApi',
            success: function() {
                location.reload();
            }
        });
    };
</script>
