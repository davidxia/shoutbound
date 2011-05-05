

<div id="posts-tab" class="main-tab-content">
  <? if ( ! $profile->posts):?>
  <div style="padding:10px 20px">
    <?=$profile->name?> hasn't posted anything yet.
  </div>
  <? endif;?>
    
  <? $first=TRUE; foreach ($profile->posts as $post):?>
  <div id="postitem-<?=$post->id?>" class="<? if($first):?><? echo 'first-item'; $first=FALSE;?><? endif;?> streamitem">
    <div class="streamitem-avatar-container">
      <a href="<?=site_url('profile/'.$profile->id)?>">
        <img src="<?=static_sub('profile_pics/'.$profile->profile_pic)?>" height="25" width="25"/>
      </a>
    </div>
      
    <div class="streamitem-content-container">
      <div class="streamitem-name">
        <a href="<?=site_url('profile/'.$profile->id)?>"><?=$profile->name?></a>
      </div>
      <div class="streamitem-content">
        <?=$post->content?>
      </div>        
      <div class="actionbar">
        <div id="repost-postitem" class="bar-item">
          <a class="add-to-trip" href="#">Add to trip</a>
        </div>
        <span class="bullet">&#149</span>
        <div class="bar-item">
          <a class="show-comments" href="#"><? $num_comments=count($post->replies); echo $num_comments.' comment'; if($num_comments!=1){echo 's';}?></a>
        </div>
        <span class="bullet">&#149</span>                    
        <div class="bar-item">
          <a class="show-trips" href="#"><? $num_trips=count($post->trips); echo $num_trips.' trip'; if($num_trips!=1){echo 's';}?></a>
        </div>
        <span class="bullet">&#149</span>                        
        <div class="bar-item">
          <abbr class="timeago subtext" title="<?=$post->created?>"><?=$post->created?></abbr>
        </div>                        
      </div>

      <!-- ADD TO TRIP -->
      <div class="add-to-trip-cont" style="display:none;">
        <select multiple="multiple" size=5>
          <? foreach ($user->rsvp_yes_trips as $trip):?>
          <option value="<?=$trip->id?>"><?=$trip->name?>
          <? endforeach;?>
          <? foreach ($user->rsvp_awaiting_trips as $trip):?>
          <option value="<?=$trip->id?>"><?=$trip->name?>
          <? endforeach;?>
          <? foreach ($user->following_trips as $trip):?>
          <option value="<?=$trip->id?>"><?=$trip->name?>
          <? endforeach;?>
        </select>
        <a class="post-to-trip" href="#">Post</a>
      </div>
      <!-- ADD TO TRIP END -->

      <!--COMMENTS START-->
      <div class="comments-container" style="display:none;">
        <? foreach ($post->replies as $comment):?>
        <div class="comment">
          <div class="streamitem-avatar-container">
            <a href="<?=site_url('profile/'.$comment->user_id)?>">
              <img src="<?=static_sub('profile_pics/'.$comment->user->profile_pic)?>" height="28" width="28"/>
            </a>
          </div>                      
          <div class="streamitem-content-container">
            <div class="streamitem-name">
              <a href="<?=site_url('profile/'.$comment->user_id)?>"><?=$comment->user->name?></a>
            </div> 
            <div class="comment-content"><?=$comment->content?></div>
            <div class="comment-timestamp"><abbr class="timeago subtext" title="<?=$comment->created?>"><?=$comment->created?></abbr></div>                      
          </div>
        </div>
        <? endforeach;?>
        <div class="comment-input-container">
          <textarea class="comment-input-area"/></textarea>
          <a class="add-comment-button" href="#">Add comment</a>
        </div>  
      </div><!--END COMMENT CONTAINER-->
  
      <!--TRIP LISTING CONTAINER START-->
      <div class="trip-listing-container" style="display:none;">
      <? foreach ($post->trips as $trip):?>
        <div class="trip-listing">
          <div class="trip-listing-name"><a href="<?=site_url('trips/'.$trip->id)?>"><?=$trip->name?></a></div>
          <div class="trip-listing-destination-container">
          <? $prefix=''; foreach ($trip->places as $place):?>
            <?=$prefix?>
            <span class="trip-listing-destination"><a href="<?=site_url('places/'.$place->id)?>"><?=$place->name?></a></span>
            <span class="subtext"><? if($place->startdate){echo date('F j, Y',$place->startdate);} if($place->startdate AND $place->enddate){echo ' - ';} if ($place->enddate){echo date('F j, Y', $place->enddate);}?></span>
            <? $prefix = '<span class="bullet">&#149</span>'?>
          <? endforeach;?>
          </div>
        </div>
      <? endforeach;?>
      </div><!--TRIP LISTING CONTAINER END-->
    </div><!--POSTITEM CONTENT CONTAINER END-->
  </div><!--END POSTITEM-->
  <? endforeach;?>
  
</div><!--END TAB-->

<script type="text/javascript">
$(function () {
  $(document.createElement('link')).attr({
      href: baseUrl+'static/css/excite-bike/jquery-ui-1.8.11.custom.css',
      media: 'screen',
      type: 'text/css',
      rel: 'stylesheet'
  }).appendTo('head');

  $.getScript(baseUrl+'static/js/jquery/jquery-ui-1.8.11.custom.min.js', function() {
    $.getScript(baseUrl+'static/js/jquery/multiselect.min.js', function() {
      $('select').multiselect();
    });
  });


  $('.show-comments').live('click', function() {
    $(this).removeClass('show-comments').addClass('hide-comments');
    $(this).parent().next().next().children('a').removeClass('hide-trips').addClass('show-trips');
    $(this).parent().parent().siblings('.trip-listing-container').hide();
    $(this).parent().parent().siblings('.comments-container').show();
    return false;
  });
  $('.hide-comments').live('click', function() {
    $(this).removeClass('hide-comments').addClass('show-comments');
    $(this).parent().parent().next().hide();
    return false;
  });
  
  $('.add-comment-button').live('click', function() {
    var content = $.trim($(this).siblings('textarea').val());
    if (content != '') {
      var parentId = $(this).parent().parent().parent().parent().attr('id').match(/^postitem-(\d+)$/)[1];
      $.post(baseUrl+'wallitems/ajax_save', {content:content, parentId:parentId},
        function (d) {
          var r = $.parseJSON(d);
          var ele = $('#postitem-'+parentId).find('.comment-input-container');
          ele.children('textarea').val('');
          ele.before('<div class="comment"><div class="postitem-avatar-container"><a href="'+baseUrl+'profile/'+r.userId+'"><img src="'+staticUrl+'profile_pics/'+r.userPic+'" width="32" height="32"></a></div><div class="comment-content-container"><div class="comment-author-name"><a href="'+baseUrl+'profile/'+r.userId+'">'+r.userName+'</a></div><div class="comment-content">'+r.content+'</div><div class="comment-timestamp"><abbr class="timeago subtext" title="'+r.created+'">'+r.created+'</abbr></div></div></div>');
          $('abbr.timeago').timeago();
        });
    }
    return false;
  });
  
  $('.show-trips').live('click', function() {
    $(this).removeClass('show-trips').addClass('hide-trips');
    $(this).parent().prev().prev().children('a').removeClass('hide-comments').addClass('show-comments');
    $(this).parent().parent().siblings('.comments-container').hide();
    $(this).parent().parent().siblings('.trip-listing-container').show();
    return false;
  });
  $('.hide-trips').live('click', function() {
    $(this).removeClass('hide-trips').addClass('show-trips');
    $(this).parent().parent().siblings('.trip-listing-container').hide();
    return false;
  });
  
  $('.add-to-trip').live('click', function() {
    $(this).parent().parent().siblings('.add-to-trip-cont').show();
    return false;
  });
  $('.post-to-trip').live('click', function () {
    var tripIds = $(this).siblings('select').multiselect('getChecked').map(function(){
      return this.value;
    }).get();
    var postId = $(this).parent().parent().parent().attr('id').match(/^postitem-(\d+)$/)[1];
    $.post(baseUrl+'home/ajax_post_item', {postId:postId, tripIds:tripIds},
      function (d) {
        var r = $.parseJSON(d);
        showPost(r);
      });
    return false;
  });
});
</script>