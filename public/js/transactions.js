$(function() {

    $('.datatable').each(function() {
        var $this = $(this);
        var pageLength = (parseInt($this.data('pagelength'))>0) ? $this.data('pagelength') : 10;

        $this.dataTable({
            sDom: "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>",
            pageLength:  pageLength,
            bSort: !$this.hasClass('no-sortable')
        });

    });

});
