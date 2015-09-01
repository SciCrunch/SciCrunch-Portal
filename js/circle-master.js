var CirclesMaster = function () {

    return {

        //Circles Master v1
        initCirclesMaster1: function () {
            //Circles 1
            $('.circle').each(function(){
                var colors = ['#eee'];
                var strings = $(this).attr('colors').split(',');
                for(var i = 0;i<strings.length;i++){
                    colors.push(strings[i]);
                }
                Circles.create({
                    id:         $(this).attr('id'),
                    radius:     20,
                    width:      6,
                    number:     $(this).attr('num'),
                    text:       '',
                    colors:     colors,
                    duration:   null
                });
            });
        },

        //Circles Master v2
        initCirclesMaster2: function () {
            var colors = [
                ['#D3B6C6', '#9B6BCC'], ['#C9FF97', '#72c02c'], ['#BEE3F7', '#3498DB'], ['#FFC2BB', '#E74C3C']
            ];

            for (var i = 1; i <= 4; i++) {
                var child = document.getElementById('circles-' + i),
                    percentage = 45 + (i * 9);

                Circles.create({
                    id:         child.id,
                    percentage: percentage,
                    radius:     70,
                    width:      2,
                    number:     percentage / 1,
                    text:       '%',
                    colors:     colors[i - 1],
                    duration:   2000
                });
            }
        }

    };

}();