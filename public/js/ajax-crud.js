function associate(a,b)
{      
           var url = $('#url').val();
           var application_id=a;
           var number=b;
           var project_id= $('#project_id').val();
           var page= $('#page').val();
           var urlone="'"+url+'/projects/'+project_id+'/'+application_id+'/reportview'+"'";
           var urltwo="'"+url+'/project/'+project_id+'/'+application_id+'/prioritizeapp/'+page+"'";
           var imgurl="'"+url+'/img/frgt_loader.gif'+"'";
          
        
    $.ajax({

            type: "GET",
            url: url + '/analyze/' + project_id + '/' +application_id,
            success: function (data) {

            var a=data.found;
            var disposition='<span>'+data.disposition+'</span>';
            var cloud=data.cloud;
            if(a == 1)
            {  
             $('#img-'+application_id).replaceWith('<button type="button" class="btn btn-outline-success btn-sm"  id="view-'+application_id+'" onclick="window.location.href='+urlone+'">View Report</button>');
             $('#disp-'+application_id).append(disposition);
             $('#cloud-'+application_id).append(cloud);
             $('#application'+number).remove();
            }

            if(a == 0)
            { 
             $('#img-'+application_id).replaceWith('<img src='+imgurl+' id="img-'+application_id+'" class="img-process" height="20" width="20" alt="In Progress..."/>');
            }
            if(a == 2)
            {
              $('#img-'+application_id).replaceWith('<button type="button" class="btn btn-outline-primary btn-sm" id="analyze-'+application_id+'" onclick="window.location.href='+urltwo+'">Analyse</button>') ;
              $('#application'+number).remove();
            }

            }
            ,
            error: function (data) 
            {
                console.log('Error:', data);
            }
        })
}
