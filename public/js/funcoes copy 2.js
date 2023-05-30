

const miniTwitter = {
    usuarios : [
        {
            username: 'lucio',

        }   
    ],

    post: [
        {
            owner: 'lucio',
            content:'Meu primeiro tweet'
        }
    ]
}

function criarPost(dados){

    miniTwitter.post.push({
        owner:dados.owner ,
        content:dados.content
    });

}

criarPost({owner:'lucio',content:'segundo post'})

console.log(miniTwitter.post)