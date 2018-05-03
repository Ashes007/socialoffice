<div class="footer <?php if(\Request::route()->getName()=='group_add'|| \Request::route()->getName()=='group_edit' || \Request::route()->getName()=='create_event' || \Request::route()->getName()=='edit_event'): ?> fixed <?php endif; ?> <?php if(\Request::route()->getName()=='home'): ?> home_footer <?php endif; ?>" >
  <div class="container">
  <p><?php echo e(trans('common.footer_text')); ?></p> 
    <?php if(\Request::route()->getName()=='group_add' || \Request::route()->getName()=='group_edit' || \Request::route()->getName()=='create_event' || \Request::route()->getName()=='edit_event'): ?>
    <div class="arrow-foot">
      <ul>
        <li>
          <a href="javascript:void(0)" class="updatebutton" data-type="prev">
            <i class="fa fa-angle-up" aria-hidden="true"></i>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)" class="updatebutton" data-type="next">
            <i class="fa fa-angle-down" aria-hidden="true"></i>
          </a>
        </li>
      </ul>
    </div>
    <?php else: ?>
    <a id="back-to-top" href="#" class="back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
    <?php endif; ?>
  </div>
</div>

<div class="custom-loader"><img src="<?php echo e(asset('frontend/images/loading_large.gif')); ?>" alt=""></div>

<script type="text/javascript">
/*$(document).ready(function() {
$(".cntlikecls").colorbox({innerWidth:500});
});*/
$(document).on('click','.cntlikecls',function(e) {
e.preventDefault();
$.colorbox({href : this.href});
});
$(document).on('click','.imgpopcls',function(e) {
e.preventDefault();
$.colorbox({href : this.href , width:"80%"});
});
</script>