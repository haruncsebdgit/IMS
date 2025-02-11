<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0;">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
        <div class="toast-body">
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="toast-message"></div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function triggerToast($message, $type = 'info') {
            var tst = $('.toast');

            tst.on("show.bs.toast", function () {
                $(".toast-body").addClass($class);
                $(".toast-message").html($message);
            });

            tst.on("hidden.bs.toast", function () {
                $(".toast-body").removeClass($class);
                $(".toast-message").html('');
            });

            switch ($type) {
                case "danger":
                    $class = "bg-danger text-white";
                    break;

                case "success":
                    $class = "bg-success";
                    break;

                case "info":
                default:
                    $class = "bg-info text-white";
                    break;
            }

            tst.toast("show");
        }
    </script>
@endpush
