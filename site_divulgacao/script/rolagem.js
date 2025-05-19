// Rolagem suave para âncoras
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href.startsWith('#')) {
                    e.preventDefault();
                    document.querySelector(href).scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Simulação de envio de formulário de contato
        document.getElementById('contatoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            this.style.display = 'none';
            document.getElementById('mensagemEnviada').style.display = 'block';
        });