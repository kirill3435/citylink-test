const table = document.getElementById('table');
const input =  document.getElementById('participants-input');
let displayTable = false;
const myModal = new bootstrap.Modal(document.getElementById("modal"), {});
const inputValidationRegexp = /[^а-яА-ЯёЁ\,]/g;
const modalError = document.getElementById('modal-error');
const participants = new Map();
const participantList = document.getElementById('participant-list');
let currentSort = 'idDesc';

function closeModal() {
    myModal.hide();
}
  
function showModal(text) {
    modalError.innerText = text;
    myModal.show();
}

function tableRender(participants) {
    participantListHtml = '';
    

    for (let entry of participants) {
        const [key, value] = entry;
        let name = key.split(';')[0];
        let id = key.split(';')[1];

        participantListHtml += `<div class="table-body"><div class="col-3">${id}</div><div class="col-6">${name}</div><div class="col-3">${value}</div></div>`;
    }
    participantList.innerHTML = participantListHtml;
};

input.addEventListener('keydown', function(event) {
    if (event.code == 'Enter') {
        addParticipant();
    }
});

function addParticipant() {
    let val = input.value;
    if (!displayTable) {
        displayTable = true;
        table.classList.add('show');
    } else {
        if (val == '') {
            showModal('Введите имена');
            return false;
        } else if (inputValidationRegexp.exec(val) != null) {
            showModal('Используйте только буквы русского алфавита и запятую');
            return false;
        }
        val = val.replace(/^[,\s]+|[,\s]+$/g, '').replace(/,[,\s]*,/g, ',');
        arrNames = val.split(',');
        id = 1;
        arrNames.forEach(element => {
            participants.set(`${element};${id}`, Math.floor(Math.random() * 100));
            id++;
        });
        tableRender(participants);
    }
}


function sort(sortByBtn = '') {
    switch(sortByBtn) {      
        case 'name':
            if (currentSort == 'nameAsc') {
                sortedParticipants = new Map([...participants.entries()].sort((a, b) => b[0].split(';')[0] - a[0].split(';')[0]).reverse());
                currentSort = 'nameDesc';
            } else {
                sortedParticipants = new Map([...participants.entries()].sort((a, b) => b[0].split(';')[0] - a[0].split(';')[0]));
                currentSort = 'nameAsc';
            }
            break;
        case 'score':
            if (currentSort == 'scoreAsc') {
                sortedParticipants = new Map([...participants.entries()].sort((a, b) => b[1] - a[1]));
                currentSort = 'scoreDesc';
            } else {
                sortedParticipants = new Map([...participants.entries()].sort((a, b) => a[1] - b[1]));
                currentSort = 'scoreAsc';
            }
            break;
        default:
            if (currentSort == 'idAsc') {
                sortedParticipants = new Map([...participants].sort((a, b) => b[0].split(';')[1] - a[0].split(';')[1]).reverse());
                currentSort = 'idDesc';
            } else {
                sortedParticipants = new Map([...participants].sort((a, b) => b[0].split(';')[1] - a[0].split(';')[1]));
                currentSort = 'idAsc';
            }
            break;
      }
      tableRender(sortedParticipants);
}