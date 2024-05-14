var total_permitted_size;
var c;
const bytesToSize = (bytes) => {
  var sizes = ["Bytes", "KB", "MB"];
  if (bytes == 0) return "0 Byte";
  else if(bytes >=26214400) {
	  total_permitted_size=1;
	  
  return ;}
   
   
  var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
  return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
};

const actualBtn = document.getElementById("btn-chose");
const fileChosen = document.getElementById("file-chosen"); 




actualBtn.addEventListener("change", function () {
  

  
  const fileExtension = this.files[0].name.split(".").pop().toUpperCase();

  
    let allow_ext = ["MP4", "MPEG","MPGA","M4A", "WAV","WEBM","MP3"];
	
	if( !allow_ext.includes(fileExtension)){
		
		return alert ("This extension is not supported");
	
		
		
	}
	

  
fileChosen.textContent =
    this.files[0].name.length > 50
      ? this.files[0].name.substr(0, 35) + "..."
      : this.files[0].name;
 
 $("#fileType").text(fileExtension);
 
  
});


$("#form").ajaxForm({
  beforeSend: function () {
   
    
    $(".uploading-status").removeClass("hidden");
    $("#uploadingProgress").css({
      "--percent": "0%",
      "--primary-color": "#06f",
      "--color": "#E6FF33",
    });
    $("#uploadingProgress").text("0%");
    $("#sendbtn").attr("disabled", true); 
   
  },
  uploadProgress: function (event, position, total, percentComplete) {
    if ($("#sendbtn").val() == "") {
		
		
		
			
			
      
	  if(c!=1){
		   $("#totalSize").text(bytesToSize(total));
		   
	  }
    
      $("#uploadingProgress").css("--percent", `${percentComplete}%`);
    //}
		}
		
		else {
      
      $("#uploadingProgress").text("Uploading...");

      $("#completedSize").text("Unallocated");
      $("#totalSize").text("Unallocated");
      $("#uploadingProgress").css("--percent", `75%`);
	  
	  
	       
		
      

    } 

   
  },
  complete: function (xhr) {
    $("#uploadingProgress").css({
      "--percent": "100%",
      "--primary-color": "#38b000",
      "--color": "#FFA533",
    });
    $("#sendbtn").attr("disabled", false); 
	
	if(total_permitted_size==1){
		$("#uploadingProgress").text("Not Completed");
		 return alert("Allowed Maximum Size For Upload: 25 MB");
	}
	else{
		
		$("#uploadingProgress").text("Completed")
	}
    
	

    
    $("#btn-chose").val("");
  
    
  },
});
