const produtosJSON = [
  {
    nome: "Perfume Rosê",
    descricao: "Suave perfume cheiro de rosas.",
    preco: "R$ 89,90",
    imagem: "https://cdn.awsli.com.br/600x450/754/754482/produto/98933672/c39c9de52e.jpg"
  },
  {
    nome: "Perfume Cítrico",
    descricao: "Fragrância energizante de frutas cítricas.",
    preco: "R$ 95,00",
    imagem: "https://epocacosmeticos.vteximg.com.br/arquivos/ids/540853-800-800/agua-fresca-citrus-cedro-adolfo-dominguez-perfume-masculino-eau-de-toilette--1-.jpg?v=638144209527670000"
  },
  {
    nome: "Perfume Amadeirado",
    descricao: "Toque forte e marcante de madeira.",
    preco: "R$ 110,00",
    imagem: "https://cdn.awsli.com.br/2500x2500/2655/2655474/produto/243378410/znbp1dcuewwahabgn7h77psnv4jhuc6mphxt_1600x1600-fill_ffffff-ojhd5bemxl.jpg"
  },
  {
    nome: "Perfume Oriental",
    descricao: "Mistura exótica com especiarias.",
    preco: "R$ 120,00",
    imagem: "https://cdn.awsli.com.br/600x1000/939/939830/produto/351296410/4b43b3aa3aad3637b1bc81348278f1b5-uvznn6sxgc.jpg"
  },
  {
    nome: "Perfume Doce",
    descricao: "Notas adocicadas com baunilha.",
    preco: "R$ 89,00",
    imagem: "https://www.giraofertas.com.br/wp-content/uploads/2023/08/Vanilla-Touch-La-Rive-Eau-de-Parfum-02.jpg"
  },
  {
    nome: "Perfume Esportivo",
    descricao: "Fresco e revigorante para o dia a dia.",
    preco: "R$ 98,90",
    imagem: "https://cdn.awsli.com.br/800x800/439/439493/produto/15240378/perfume-chanel-allure-homme-sport-masculino-eau-de-toilette-tdm68sfq28.jpg"
  },
  {
    nome: "Perfume Intenso",
    descricao: "Fragrância profunda e sofisticada.",
    preco: "R$ 105,00",
    imagem: "https://cdn11.bigcommerce.com/s-rfhyfx8aa2/images/stencil/1280x1280/products/716/1014/malbec_club_intenso__95053.1705353762.jpg?c=2"
  },
  {
    nome: "Perfume Oceânico",
    descricao: "Aroma refrescante com notas marinhas.",
    preco: "R$ 92,00",
    imagem: "https://www.mundodosdecants.com.br/wp-content/uploads/2021/03/Ocean-di-Gioia-Giorgio-Armani-600x600.jpg"
  },
  {
    nome: "Perfume Lavanda",
    descricao: "Relaxante e delicado, com lavanda pura.",
    preco: "R$ 85,00",
    imagem: "https://s3-sa-east-1.amazonaws.com/files2.aprendaerp.com.br/Producao/0e877c35-f117-4b25-8cf5-87680f96950c/ImagensProdutos/6509a89d0d280d83e8222c17_600x600.jpeg"
  },
  {
    nome: "Perfume Noturno",
    descricao: "Elegante e misterioso para a noite.",
    preco: "R$ 130,00",
    imagem: "https://images.tcdn.com.br/img/img_prod/1361374/sparkle_night_deamon_lonkoom_perfume_arabe_feminino_elegante_intenso_e_noturno_com_toque_oriental_se_1697_2_b287eb8eb1e730636c7e28a7508e7396.png"
  },
  {
    nome: "Perfume Frutado",
    descricao: "Combinado de frutas tropicais.",
    preco: "R$ 88,00",
    imagem: "https://cdn.awsli.com.br/2500x2500/2655/2655474/produto/243379306/ji26rrlug4zvv3lucwi2gjkyxo469f1xi61d_1600x1600-fill_ffffff-50g128nzoi.jpg"
  },
  {
    nome: "Perfume Floral Luxo",
    descricao: "Versão premium com jasmim e rosa.",
    preco: "R$ 150,00",
    imagem: "https://images.tcdn.com.br/img/img_prod/611043/floral_edp_100ml_bies_5131_1_f3e8fcfc283b3e203de5c0daacb7cbea.jpg"
  }
];

const produtosContainer = document.getElementById('produtos');
const verMaisBtn = document.getElementById('verMais');

let produtosVisiveis = 0;
const produtosPorPagina = 6;

function carregarProdutos() {
  const fim = produtosVisiveis + produtosPorPagina;
  const proximos = produtosJSON.slice(produtosVisiveis, fim);

  proximos.forEach(produto => {
    const div = document.createElement('div');
    div.classList.add('produto');
    div.innerHTML = `
      <img src="${produto.imagem}" alt="${produto.nome}">
      <h3>${produto.nome}</h3>
      <p>${produto.descricao}</p>
      <p class="preco">${produto.preco}</p>
      <a href="https://wa.me/5511912345678?text=Olá, gostaria de comprar o ${encodeURIComponent(produto.nome)}" target="_blank">Comprar no WhatsApp</a>
    `;
    produtosContainer.appendChild(div);
  });

  produtosVisiveis += produtosPorPagina;

  if (produtosVisiveis >= produtosJSON.length) {
    verMaisBtn.style.display = 'none';
  }
}

verMaisBtn.addEventListener('click', carregarProdutos);

// Carrega os primeiros produtos ao iniciar
carregarProdutos();