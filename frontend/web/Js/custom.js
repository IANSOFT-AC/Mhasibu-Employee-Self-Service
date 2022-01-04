/**
 * Created by HP ELITEBOOK 840 G5 on 1/6/2021.
 * Written with love by @francnjamb -- Twitter
 */





//Initialize Sweet Alert

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

 function closeInput(elm) {
  var td = elm.parentNode;
  var value = elm.value;
  


  /** Handle Checkbox state */
  var child = td.children[0];

  if(child.type == 'checkbox'){
    value = (child.checked)? true: false;
  }

  /** Finish handling checkbox state */



  td.removeChild(elm);
  td.innerHTML = value;

  const data = td.dataset;
  // console.table(data);

  // Post Changes
  field = document.querySelector(`#${data.validate}`);
  $.post('./commit',{'key':data.key,'name': data.name, 'no': data.no,'filterKey': data.filterField,'service': data.service, 'value': value }).done(function(msg){
    //console.log(data.validate);

    if(data.validate)
    {
      const DataKey = data.validate;
      field.innerText = typeof(msg) === 'string'? msg : msg[data.name];
      console.log('Baby we getting here..');
      console.log(msg);
    }

  });
}

function addInput(elm,type = false, field = false ) {
  if (elm.getElementsByTagName('input').length > 0) return;

   

  var value = elm.innerHTML;
   elm.innerHTML = '';

  var input = document.createElement('input');
  if(type){
    input.setAttribute('type', type);
  }else{
    input.setAttribute('type', 'text');
  }

  input.setAttribute('value', value);

  if(type === 'checkbox')
  {
    input.checked = event.target.value;  
    
  }


  
  input.setAttribute('class','form-control');
  input.setAttribute('onBlur', 'closeInput(this)');
  elm.appendChild(input);
  input.focus();
}

async function addDropDown(elm,resource) {
  if (elm.getElementsByTagName('input').length > 0) return;

  var value = elm.innerHTML;
  elm.innerHTML = '';

  const ddContent = await getData(resource);

  console.table(ddContent);


  var select = document.createElement('select');
  const InitialOption = document.createElement('option');

  InitialOption.innerText = 'Select ...';
  select.appendChild(InitialOption);

  // Prepare the returned data and append it on the select

  for(const[key, value] of Object.entries(ddContent)){
        // console.log(`${key}: ${value}`);
        const option = document.createElement('option');
        option.value = key;
        option.text = value;

        select.appendChild(option);
  }

  select.setAttribute('class','form-control');
  select.setAttribute('onChange', 'closeInput(this)');
  elm.appendChild(select);
  select.focus();
}


async function getData(resource)
{
  const res = await fetch(`./${resource}`,{
  headers: new Headers({
    Origin: 'http://localhost:2026/'
  })
});
  const data = await res.json();

  return data;
}


function JquerifyField(model, fieldName) {
  field = fieldName.toLowerCase();
  const selector =   '#'+model+'-'+field;
  return selector;
}

// Function to do ajax field level updating

function globalFieldUpdate(entity,controller = false, fieldName, ev, autoPopulateFields = []) {
  console.log('Global Field Update was invoked');
  const model = entity.toLowerCase();
  const field = fieldName.toLowerCase();
  const formField = '.field-'+model+'-'+fieldName.toLowerCase();
  const keyField ='#'+model+'-key'; 
  const targetField = '#'+model+'-'.field;
  const tget = '#'+model+'-'+field;

  
  const fieldValue = ev.target.value;
  const Key = $(keyField).val();

  console.log(`My Key is ${Key}`);
  console.log(autoPopulateFields);
 
  let route = '';
  // If controller is falsy use the model value (entity) as the route
  if(!controller) {
    route = model;
  }else {
    route = controller;
  }

  console.log(`route to use is : ${route}`);
  

  if(Key.length){
      const url = $('input[name=absolute]').val()+route+'/setfield?field='+fieldName;
      $.post(url,{ fieldValue:fieldValue,'Key': Key}).done(function(msg){
          
              // Populate relevant Fields
                                         
              $(keyField).val(msg.Key);
              $(targetField).val(msg[fieldName]);

              // Update DOM values for fields specified in autoPopulatedFields: fields in this array should be exact case and name as specified in Nav Web Service 

              if(autoPopulateFields.length > 0) {
                autoPopulateFields.forEach((field) => {
                  let domSelector = JquerifyField(model,field);

                  console.log(`Field of Corncern is ${field}`);
                  console.log(`Model of Corncern is ${model}`);
                  console.log(`Jquerified field is ${domSelector}`);
                  $(domSelector).val(msg[field]);
                });
              }

             /*******End Field auto Population  */
              if((typeof msg) === 'string') { // A string is an error
                  console.log(`Form Field is: ${formField}`);
                  const parent = document.querySelector(formField);

                  // Update Request Status from Server
                  requestStateUpdater(parent,'error', msg);

                  // Fire a sweet alert if you can

                  Toast.fire({
                    type: 'error',
                    title: msg
                  })
                  
              }else{ // An object represents correct details

                  const parent = document.querySelector(formField);
                 
                  // Update Request Status from Server
                  requestStateUpdater(parent,'success');

                  // If you can Fire a sweet alert                  

                  Toast.fire({
                    type: 'success',
                    title: field+' Saved Successfully.'
                  })
                  
              }   
          },'json');
  }

}         
function disableSubmit(){
document.getElementById('submit').setAttribute("disabled", "true");
}

function enableSubmit(){
  document.getElementById('submit').removeAttribute("disabled");
}

function requestStateUpdater(fieldParentNode, notificationType, msg = '' ) {
  let inputParentNode = fieldParentNode.children[1]; // This is in boostrap 5

  if(notificationType === 'success' ){
    let successElement = document.createElement('span');
    successElement.innerText = 'Data Saved Successfully.';
    successElement.setAttribute('class', 'text-success small');
    inputParentNode.append(successElement);

    // clean up the notification elements after 3 seconds
    setTimeout(() => {
      successElement.remove();
    }, 3000);

  } else if(notificationType === 'error' && msg){

    let errorElement = document.createElement('span');
    errorElement.innerText = `Message: ${msg}`;
    errorElement.setAttribute('class', 'text-danger small');
    inputParentNode.append(errorElement);

    // clean up the notification elements after 3 seconds
    setTimeout(() => {
      errorElement.remove();
      location.reload(true);
    }, 7000);

  }
  
  

  
    
  
  
}





