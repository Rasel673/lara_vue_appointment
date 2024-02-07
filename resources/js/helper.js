import moment from "moment";



export function formatedDate(value){
    
    if(value){
      return moment(String(value)).format('DD-MM-YYYY')  
    }

}