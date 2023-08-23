<footer>
    <div class="footer-content">
        <!-- ここにフッターのコンテンツを記述 -->
        <p>&copy; {{ date('Y') }} dog-friendly. All rights reserved.</p>
        <p>連絡先: dog-freendly@example.com</p>
        
        <div class="footer-links">
            <div style="display: flex;">
                <img src="/img/footer3.png" alt="画像の説明">
                <img src="/img/footer4.png" alt="画像の説明">
            </div>
            <ul style="list-style: none; display: inline-block;">
                <li><a href="/dog-friendly">ホーム</a></li>
                <li><a href="/">新規登録</a></li>
                <li><a href="/roguin">ログイン</a></li>
            </ul>
            <img src="/img/footer.png" alt="画像の説明">
            <img src="/img/footer2.png" alt="画像の説明">
        </div>
    </div>
   
</footer>
<style>
footer {
    background-color: #C0C0C0;
    color: black;
    padding: 20px;
    text-align: center;
    width: 100%;
    margin-top: 20px;
}

footer p {
    margin: 0;
}

footer a {
    
    text-decoration: none;
}

footer ul {
    
    padding: 0;
    
}

footer ul li {
    margin-top: 5px;
}

/* 本文のスタイル */
.content {
    padding: 20px;
    margin-bottom: 50px; /* フッターの高さ分余白を作成 */
}
.footer-links {
    display: flex; /* 横並びにする */
    align-items: center; /* 縦方向に中央揃え */
    justify-content: flex-end;
}

.footer-content {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.footer-links ul {
    list-style: none;
    text-align: center;
}

.footer-content a{
    color: black;
}
.footer-links img {
    width: 100px;
    height: 100px;
}

@media screen and (max-width: 600px) {
.footer-links img {
    width: 80px;
    height: 80px;
}   
}
@media screen and (max-width: 450px) {
.footer-links img {
    width: 65px;
    height: 65px;
}   
}
</style>