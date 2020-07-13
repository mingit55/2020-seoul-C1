class Store {
    constructor() {
        // 해시 모듈
        this.searchHashModule;
        this.addHashModule;

        // 폼 인풋
        this.addImage = document.querySelector("#paper_image");
        this.addName = document.querySelector("#paper_name");
        this.addCompany = document.querySelector("#company_name");
        this.addWidth = document.querySelector("#width_size");
        this.addHeight = document.querySelector("#height_size");
        this.addPoint = document.querySelector("#point");

        // 한지 데이터
        this.papers = [];
        this.uid = document.querySelector("#uid").value;

        // 인덱스드 디비
        // this.idb = new IDB("jeonju", ["papers", "buyList"], () => this.init());
        this.init();
    }

    // 데이터 불러오기
    loadPapers(){
        fetch("/papers")
            .then(res => res.json())
            .then(data => {
                console.log(data);
                this.papers = data.papers; // 데이터 불러오기
                this.papers.map(p => {p.cnt = 0; return p});
                return data;
            })
            .then(() => {
                this.setHahModule();    
            });
        // this.idb.getList("papers") // 디비 데이터 가져오기
        //     .then((data) => {
        //         console.log(data);
        //         if(data.length == 0){ // 디비에 데이터가 없으면 데이터 삽입
        //             fetch("/json/papers.json")
        //                 .then(res => res.json())
        //                 .then(res => {
        //                     this.papers = res.map(item => {
        //                         item.buy = 0;
        //                         item.width_size=parseInt(item.width_size);
        //                         item.height_size=parseInt(item.height_size);
        //                         item.point=parseInt(item.point);
        //                         item.image = "/images/papers/" + item.image; 
        //                         return item;
        //                     });
            
        //                     this.papers.forEach(paper => {
        //                         this.idb.add("papers", paper);
        //                     });
        //                     this.counts = new Array(this.papers.length).fill(0);
        //                     console.log(this.counts);
        //                     this.setHahModule();
        //                 })
        //         }else{
        //             this.papers = data; // 데이터 불러오기
        //             this.counts = new Array(this.papers.length).fill(0);
        //         }
        //         return data;
        //     })
        //     .then(() => {
        //         this.setHahModule();    
        //     });
    }

    // 해시 모듈 설정
    setHahModule(){
        this.searchHashModule = new HashModule("#search-hash", this.getAllHashs());
        this.searchHashModule.init();
        // console.log();

        if(document.querySelector("#add-hash")){
            this.addHashModule = new HashModule("#add-hash", this.getAllHashs());
            this.addHashModule.init();
        }
        this.rendering();
    }

    init() {
        this.loadPapers();
        
        // 검색 이벤트 설정
        document.querySelector("#search-btn").addEventListener("click", e => {
            this.rendering();
        });

        // 너비 높이 입력 제한 이벤트
        if(this.addWidth && this.addHeight){
            this.addWidth.addEventListener("input", e =>{
                e.preventDefault();
                e.target.value = e.target.value.replace(/[^0-9]+/g, "");
            });
            this.addHeight.addEventListener("input", e =>{
                e.preventDefault();
                e.target.value = e.target.value.replace(/[^0-9]+/g, "");
            });
            this.addWidth.addEventListener("change", e =>{
                if(e.target.value < 100)e.target.value = 100;
                if(e.target.value > 1000)e.target.value = 1000;
            });
            this.addHeight.addEventListener("change", e =>{
                if(e.target.value < 100)e.target.value = 100;
                if(e.target.value > 1000)e.target.value = 1000;
            });
        }
        
        // 포안트 입력 제한 이벤트
        if(this.addPoint){
            this.addPoint.addEventListener("input", e =>{
                e.preventDefault();
                e.target.value = e.target.value.replace(/[^0-9]+/g, "");
            });
            this.addPoint.addEventListener("change", e =>{
                if(e.target.value < 10)e.target.value = 10;
                if(e.target.value > 1000)e.target.value = 1000;
                e.target.value = parseInt(e.target.value / 10) * 10;
            });
        }

        // 이미지 입력제한 이벤트
        if(this.addImage){
            this.addImage.addEventListener("change", e => {
                let image = e.target.files[0];
                if(image.type.substring(0, 5) == "image"){
                    if(image.type == "image/jpeg" ||
                        image.type == "image/png" || 
                        image.type == "image/gif"){
                        if(image.size / 1024 / 1024 > 5){
                            alert("파일 크기는 5MB를 넘을 수 없습니다.");
                            e.preventDefault();
                            e.target.value = "";
                        }
                    }else{
                        alert("jpg, png, gif 만 가능");
                        e.preventDefault();
                        e.target.value = "";
                        return false;    
                    }
                }else{
                    alert("이미지 파일이 아닙니다.");
                    e.preventDefault();
                    e.target.value = "";
                    return false;
                }
            });
        }

        // 추가하기 이벤트
        let form = document.querySelector("#add-modal form");
        if(form){
            form.addEventListener("submit", e=> {
                e.preventDefault();
                if(this.addHashModule.hashs.length == 0){
                    return false;
                }
                this.getImageURL(this.addImage.files[0])
                    .then(url =>{
                        let paper = {
                            id: this.papers.length + 1,
                            uid: this.uid,
                            image : url,
                            paper_name : this.addName.value,
                            company_name : this.addCompany.value,
                            width_size: parseInt(this.addWidth.value),
                            height_size : parseInt(this.addHeight.value),
                            point: parseInt(this.addPoint.value),
                            hash_tags : this.addHashModule.hashs.map(hash => hash.data),
                            cnt : 0
                        };
                        this.clearModal();
                        $.post("/papers", paper, updated => {
                            paper.image = updated.image;
                            alert("추가되었습니다.");
                            this.papers.push(paper);
                            this.searchHashModule.updateAutoHash(this.getAllHashs());
                            this.addHashModule.updateAutoHash(this.getAllHashs());
                            this.rendering();
                        });
                    });
            });
        }

        // 구매하기 이벤트
        document.querySelector("#buy_btn").addEventListener("click", (e) => { 
            let cnt = this.papers.reduce((p, c) => p + c.cnt, 0);
            if(cnt === 0) {
                alert("구매할 한지를 선택해 주세요!");
            } else {
                $.post("/store", {list: this.papers.filter(paper => paper.cnt > 0), totalPoint: this.papers.reduce((p, c) => p + c.cnt * c.point, 0)}, res => {
                    if(!res.message){
                        alert(`총 ${cnt}개의 한지가 구매되었습니다.`);
                        this.papers.forEach(paper => paper.cnt = 0);
                        location.reload();
                    } else {
                        alert(res.message);
                    }
                });
            }
        });
    }

    // 모달 입력창 초기화
    clearModal(){
        this.addImage.value = "";
        this.addName.value = "";
        this.addCompany.value = "";
        this.addWidth.value = 100;
        this.addHeight.value = 100;
        this.addPoint.value = 10;
        this.addHashModule.resetHash();
        $("#add-modal").modal("hide");
    }
    // 리스트 렌더
    renderPaperList(){
        let div = document.createElement("div");

        // 검색 필터 적용
        let filteredPaper = this.papers;

        if(this.searchHashModule.hashs.length > 0)
        filteredPaper = this.papers.filter(paper => {
            let flag = false;

            this.searchHashModule.hashs.forEach(hash => {
                if(paper.hash_tags.includes(hash.data)){
                    flag = true;
                }
            });

            return flag;
        });
        
        // 리스트 비우기
        document.querySelector("#paper_list").innerHTML = "";
        filteredPaper.forEach((paper, idx) => {
            let tags = [];
            paper.hash_tags.forEach(tag => {
                tags.push(`<span class="badge">${tag}</span>`);
            });
            let uidCheck = this.uid == paper.uid;
            div.innerHTML = `<div class="col-lg-3 col-md-6 mb-4 paper-item" data-id="${paper.id}">
                <div class="card">
                    <img class="card-img-top" src="/uploads/papers/${paper.image}" alt="한지 이미지">
                    <div class="card-body">
                        <div>
                            <b class="card-title">${paper.paper_name}</b>
                            <span class="badge badge-primary">${paper.point}p</span>
                        </div>
                        <div class="card-text mt-2">
                            <span class="text-muted">${paper.company_name}</span>
                            <span class="text-muted">${paper.width_size}px × ${paper.height_size}px</span>
                        </div>
                        <div class="card-text mt-2">
                            ${tags.join("")}
                        </div>
                        ${
                            uidCheck ? "" :
                            "<button class='btn btn-primary mt-3'>구매하기</button>"
                        }
                    </div>
                </div>
            </div>`;

            // 카트에 추가하기 이벤트
            let paperItem = div.firstChild;
            if(!uidCheck){
                paperItem.querySelector("button").addEventListener("click", () => {
                    this.papers[idx].cnt++;
                    this.rendering();
                })
            }
            document.querySelector("#paper_list").append(paperItem);
        });
    }

    // 갯수 업데이트
    updatePaperList(){
        this.papers.forEach((paper, idx) => {
            if(this.uid !== paper.uid){
                let node = document.querySelector(`.paper-item[data-id='${paper.id}']`);
                if(node !== null){
                    let text = "구매하기";
                    if(paper.cnt > 0){
                        text = `추가하기(${paper.cnt}개)`;
                    }
                    node.querySelector("button").innerText = text;
                }
            }
        });
    }

    renderBuyList(){
        // 리스트 비우기
        document.querySelector("#buy_list").innerHTML = "";
        this.papers.forEach((paper, idx) => {
            if(paper.cnt === 0)return;
            let table = document.createElement("table");
            table.innerHTML = `<tr>
                <td>
                    <img src="/uploads/papers/${paper.image}" alt="한지 이미지" width="60" height="60">
                </td>
                <td>${paper.paper_name}</td>
                <td>${paper.company_name}</td>
                <td>${paper.point}p</td>
                <td><input type="number" class="buy-cnt" class="form-control" value='${paper.cnt}'>개</td>
                <td>${parseInt(paper.point) * paper.cnt}p</td>
                <th>
                    <button class="btn btn-danger">삭제하기</button>
                </th>
            </tr>`;

            // 삭제 이벤트
            let buyItem = table.querySelector("tr");
            buyItem.querySelector("button").addEventListener("click", () => {
                this.papers[idx].cnt = 0;
                this.rendering();
            });

            buyItem.querySelector("input").addEventListener("input", e =>{
                e.preventDefault();
                e.target.value = e.target.value.replace(/[^0-9]+/g, "");
            });
            buyItem.querySelector("input").addEventListener("change", e =>{
                if(e.target.value < 1)e.target.value = 1;
                if(e.target.value > 1000)e.target.value = 1000;
                this.papers[idx].cnt = parseInt(e.target.value);
                this.rendering();
            });

            document.querySelector("#buy_list").append(buyItem);
        });
        
        let totalPoint = this.papers.map((paper, idx) => paper.cnt * parseInt(paper.point)).reduce((sum, val) => sum + val, 0);
        document.querySelector("#total_point").innerText = totalPoint + "p";
    }

    rendering(){
        this.renderPaperList();
        this.renderBuyList();
        this.updatePaperList();
    }

    // 사용자 입력 이미지 데이터화
    getImageURL(file){
        return new Promise(resolve => {
            let getImage = new Promise(res => {
                let reader = new FileReader();
                reader.onload = () => res(reader.result);
                reader.readAsDataURL(file);
            });
    
            getImage.then(url => {
                let image = new Image();
                image.src = url;
                image.onload = () => {
                    let cropSize = 64; 
                    let canvas = document.createElement("canvas")
                        , ctx = canvas.getContext("2d")
                        , cx, cy, cw, ch; // crop x, y, w, h
                    canvas.width = cropSize;
                    canvas.height = cropSize;
    
                    if(image.width > image.height){
                        cw = ch = image.height; 
                        cx = (image.width - image.height) / 2;
                        cy = 0;
                    } else {
                        cw = ch = image.width;
                        cx = 0;
                        cy = (image.height - image.width) / 2;
                    }
                    ctx.drawImage(image, cx, cy, cw, ch, 0, 0, cropSize, cropSize);
                    resolve(canvas.toDataURL("image/jpg"));
                };
            });
        });
    }

    // 모든 해시 데이터 추출
    getAllHashs() {
        let hash = [];
        this.papers.forEach(item => {
            item.hash_tags.forEach(tag => {
                if (!hash.includes(tag)) {
                    hash.push(tag);
                }
            });
        });
        return hash;
    }
}

window.onload = () => {
    let app = new Store();
};
