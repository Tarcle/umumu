Vue.mixin({
    methods: {
        display_datetime: function (data) {
            if (!data) return '';
    
            diff = new Date() - new Date(data);
            
            s = 1000; //1초
            m = s * 60; //1분 = 60초
            h = m * 60; //1시간 = 60분
            d = h * 24; //1일 = 24시간
            y = d * 365; //1년 = 1일 * 10일
    
            if (diff < m) {
                result = Math.floor(diff/s) + '초 전';
            } else if (h > diff && diff >= m) {
                result = Math.floor(diff/m) + '분 전';
            } else if (d > diff && diff >= h) {
                result = Math.floor(diff/h) + '시간 전';
            } else if (y > diff && diff >= d) {
                result = Math.floor(diff/d) + '일 전';
            } else {
                result = Math.floor(diff/y) + '년 전';
            }
    
            return result;
        },
        keypress_button: function (e, func) {
            if(e.keyCode==13) {
                e.preventDefault();
                func();
            }
        }
    }
});
