<script type="text/javascript">
$.notify({
    message: '{{ session($section) }}'
},{
	template: '<div class="ui tiny blue message">{2}</div>', 
    placement: {
        from: 'top',
        align: 'right'
    },
    delay: 3200,
    animate: {
        enter: 'animated fadeInRight',
        exit: 'animated fadeOutRight'
    },
    offset: {
        x: 15,
        y: 75
    }
});
</script>