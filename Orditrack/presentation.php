<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notre équipe - Orditrack</title>
    <style>
        :root { color-scheme: light dark; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; line-height: 1.5; }
        header, footer { padding: 16px 20px; }
        header { border-bottom: 1px solid rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; }
        .brand { display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 18px; }
        .brand img { height: 28px; width: 28px; }
        .back-link { text-decoration: none; color: #0a58ca; font-weight: 600; }
        .back-link:hover { text-decoration: underline; }

        .hero { padding: 32px 20px 8px; text-align: center; }
        .hero h1 { margin: 0 0 8px; font-size: clamp(24px, 4vw, 34px); }
        .hero p { margin: 0; color: #555; }

        .container { max-width: 1080px; margin: 0 auto; padding: 16px 20px 32px; }
        .team-grid { display: grid; grid-template-columns: repeat(1, minmax(0,1fr)); gap: 20px; }
        @media (min-width: 560px) { .team-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
        @media (min-width: 900px) { .team-grid { grid-template-columns: repeat(3, minmax(0,1fr)); } }

        .card { background: rgba(255,255,255,0.7); border: 1px solid rgba(0,0,0,0.08); border-radius: 12px; padding: 18px; display: flex; flex-direction: column; gap: 12px; backdrop-filter: blur(4px); }
        .card:hover { box-shadow: 0 4px 18px rgba(0,0,0,0.08); }
        .member { display: flex; align-items: center; gap: 14px; }
        .avatar { height: 64px; width: 64px; border-radius: 999px; background: linear-gradient(135deg, #e9ecef, #dee2e6); display: grid; place-items: center; color: #333; font-weight: 700; font-size: 20px; border: 1px solid rgba(0,0,0,0.06); }
        .avatar[data-initials]::after { content: attr(data-initials); }
        .avatar-img { height: 64px; width: 64px; border-radius: 999px; object-fit: cover; border: 1px solid rgba(0,0,0,0.06); }
        .name { margin: 0; font-size: 18px; font-weight: 700; }
        .role { margin: 0; color: #666; font-size: 14px; }
        .bio { margin: 8px 0 0; color: #444; font-size: 14px; }
        .tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px; }
        .tag { font-size: 12px; padding: 4px 8px; border-radius: 999px; background: #f1f3f5; color: #333; border: 1px solid rgba(0,0,0,0.06); }

        footer { border-top: 1px solid rgba(0,0,0,0.1); text-align: center; color: #666; font-size: 14px; }

        /* Réseaux sociaux */
        .socials { display: flex; gap: 10px; margin-top: 10px; }
        .social-link { width: 32px; height: 32px; display: grid; place-items: center; border-radius: 8px; border: 1px solid rgba(0,0,0,0.08); background: #fff; text-decoration: none; }
        .social-link svg { width: 18px; height: 18px; }
        .social-link:hover { box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
    <header>
        <div class="brand">
            <img src="img/ico.png" alt="Orditrack">
            <span>Orditrack</span>
        </div>
        <a class="back-link" href="index.php">← Retour à l'accueil</a>
    </header>

    <section class="hero">
        <h1>Faites connaissance avec notre équipe</h1>
        <p>Une équipe engagée pour simplifier la gestion du prêt de PC.</p>
    </section>

    <main class="container">
        <div class="team-grid">
            <article class="card">
                <div class="member">
                    <div class="avatar" data-initials="AB" aria-label="Avatar AB"></div>
                    <div>
                        <h3 class="name">Carole ...</h3>
                        <p class="role">Cheffe de projet</p>
                    </div>
                </div>
                <p class="bio">Coordonne la roadmap, veille à la qualité et à la livraison.</p>
                <div class="tags">
                    <span class="tag">Pilotage</span>
                    <span class="tag">Qualité</span>
                    <span class="tag">Communication</span>
                </div>
                <div class="socials">
                    <a class="social-link" href="https://github.com/" target="_blank" rel="noopener" aria-label="GitHub">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5a12 12 0 0 0-3.79 23.39c.6.11.82-.26.82-.58v-2.02c-3.34.73-4.04-1.61-4.04-1.61-.55-1.4-1.35-1.77-1.35-1.77-1.1-.75.08-.74.08-.74 1.22.09 1.86 1.25 1.86 1.25 1.08 1.85 2.83 1.32 3.52 1.01.11-.78.42-1.32.76-1.63-2.66-.3-5.46-1.33-5.46-5.9 0-1.3.47-2.36 1.24-3.19-.13-.3-.54-1.52.12-3.16 0 0 1.01-.32 3.3 1.22a11.5 11.5 0 0 1 6 0c2.29-1.54 3.3-1.22 3.3-1.22.66 1.64.25 2.86.12 3.16.77.83 1.24 1.89 1.24 3.19 0 4.58-2.8 5.6-5.48 5.9.43.37.81 1.1.81 2.22v3.29c0 .32.21.7.82.58A12 12 0 0 0 12 .5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://www.linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5.001 2.5 2.5 0 0 1 0-5Zm.02 6H2v11h3V9.5Zm4 0H6v11h3v-6.1c0-1.62.3-3.19 2.32-3.19 1.99 0 2.01 1.86 2.01 3.29V20.5h3v-6.65c0-3.2-.69-5.67-4.42-5.67-1.79 0-2.99.98-3.49 1.9h-.05V9.5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://x.com/" target="_blank" rel="noopener" aria-label="X">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.2 2H21l-6.39 7.3L22 22h-6.8l-4.8-6.2L5 22H2.2l6.84-7.82L2 2h6.97l4.33 5.7L18.2 2Zm-1.2 18h1.88L7.08 4H5.14L17 20Z"/></svg>
                    </a>
                </div>
            </article>

            <article class="card">
                <div class="member">
                    <div class="avatar" data-initials="JM" aria-label="Avatar JM"></div>
                    <div>
                        <h3 class="name">Jacob Martin</h3>
                        <p class="role">Développeur backend</p>
                    </div>
                </div>
                <p class="bio">Conçoit les APIs, la base de données et la sécurité applicative.</p>
                <div class="tags">
                    <span class="tag">PHP</span>
                    <span class="tag">MySQL</span>
                    <span class="tag">Sécurité</span>
                </div>
                <div class="socials">
                    <a class="social-link" href="https://github.com/" target="_blank" rel="noopener" aria-label="GitHub">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5a12 12 0 0 0-3.79 23.39c.6.11.82-.26.82-.58v-2.02c-3.34.73-4.04-1.61-4.04-1.61-.55-1.4-1.35-1.77-1.35-1.77-1.1-.75.08-.74.08-.74 1.22.09 1.86 1.25 1.86 1.25 1.08 1.85 2.83 1.32 3.52 1.01.11-.78.42-1.32.76-1.63-2.66-.3-5.46-1.33-5.46-5.9 0-1.3.47-2.36 1.24-3.19-.13-.3-.54-1.52.12-3.16 0 0 1.01-.32 3.3 1.22a11.5 11.5 0 0 1 6 0c2.29-1.54 3.3-1.22 3.3-1.22.66 1.64.25 2.86.12 3.16.77.83 1.24 1.89 1.24 3.19 0 4.58-2.8 5.6-5.48 5.9.43.37.81 1.1.81 2.22v3.29c0 .32.21.7.82.58A12 12 0 0 0 12 .5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://www.linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5.001 2.5 2.5 0 0 1 0-5Zm.02 6H2v11h3V9.5Zm4 0H6v11h3v-6.1c0-1.62.3-3.19 2.32-3.19 1.99 0 2.01 1.86 2.01 3.29V20.5h3v-6.65c0-3.2-.69-5.67-4.42-5.67-1.79 0-2.99.98-3.49 1.9h-.05V9.5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://x.com/" target="_blank" rel="noopener" aria-label="X">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.2 2H21l-6.39 7.3L22 22h-6.8l-4.8-6.2L5 22H2.2l6.84-7.82L2 2h6.97l4.33 5.7L18.2 2Zm-1.2 18h1.88L7.08 4H5.14L17 20Z"/></svg>
                    </a>
                </div>
            </article>

            <article class="card">
                <div class="member">
                    <div class="avatar" data-initials="SR" aria-label="Avatar SR"></div>
                    <div>
                        <h3 class="name">Chris Techer</h3>
                        <p class="role">Développeuse frontend</p>
                    </div>
                </div>
                <p class="bio">Crée des interfaces claires et accessibles pour tous les utilisateurs.</p>
                <div class="tags">
                    <span class="tag">HTML/CSS</span>
                    <span class="tag">UX</span>
                    <span class="tag">Accessibilité</span>
                </div>
                <div class="socials">
                    <a class="social-link" href="https://github.com/" target="_blank" rel="noopener" aria-label="GitHub">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5a12 12 0 0 0-3.79 23.39c.6.11.82-.26.82-.58v-2.02c-3.34.73-4.04-1.61-4.04-1.61-.55-1.4-1.35-1.77-1.35-1.77-1.1-.75.08-.74.08-.74 1.22.09 1.86 1.25 1.86 1.25 1.08 1.85 2.83 1.32 3.52 1.01.11-.78.42-1.32.76-1.63-2.66-.3-5.46-1.33-5.46-5.9 0-1.3.47-2.36 1.24-3.19-.13-.3-.54-1.52.12-3.16 0 0 1.01-.32 3.3 1.22a11.5 11.5 0 0 1 6 0c2.29-1.54 3.3-1.22 3.3-1.22.66 1.64.25 2.86.12 3.16.77.83 1.24 1.89 1.24 3.19 0 4.58-2.8 5.6-5.48 5.9.43.37.81 1.1.81 2.22v3.29c0 .32.21.7.82.58A12 12 0 0 0 12 .5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://www.linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5.001 2.5 2.5 0 0 1 0-5Zm.02 6H2v11h3V9.5Zm4 0H6v11h3v-6.1c0-1.62.3-3.19 2.32-3.19 1.99 0 2.01 1.86 2.01 3.29V20.5h3v-6.65c0-3.2-.69-5.67-4.42-5.67-1.79 0-2.99.98-3.49 1.9h-.05V9.5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://x.com/" target="_blank" rel="noopener" aria-label="X">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.2 2H21l-6.39 7.3L22 22h-6.8l-4.8-6.2L5 22H2.2l6.84-7.82L2 2h6.97l4.33 5.7L18.2 2Zm-1.2 18h1.88L7.08 4H5.14L17 20Z"/></svg>
                    </a>
                </div>
            </article>

            <article class="card">
                <div class="member">
                    <div class="avatar" data-initials="TG" aria-label="Avatar TG"></div>
                    <div>
                        <h3 class="name">Thibault Benard</h3>
                        <p class="role">DevOps</p>
                    </div>
                </div>
                <p class="bio">Assure la stabilité, l'automatisation et les déploiements sécurisés.</p>
                <div class="tags">
                    <span class="tag">CI/CD</span>
                    <span class="tag">Monitoring</span>
                    <span class="tag">Cloud</span>
                </div>
                <div class="socials">
                    <a class="social-link" href="https://github.com/" target="_blank" rel="noopener" aria-label="GitHub">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5a12 12 0 0 0-3.79 23.39c.6.11.82-.26.82-.58v-2.02c-3.34.73-4.04-1.61-4.04-1.61-.55-1.4-1.35-1.77-1.35-1.77-1.1-.75.08-.74.08-.74 1.22.09 1.86 1.25 1.86 1.25 1.08 1.85 2.83 1.32 3.52 1.01.11-.78.42-1.32.76-1.63-2.66-.3-5.46-1.33-5.46-5.9 0-1.3.47-2.36 1.24-3.19-.13-.3-.54-1.52.12-3.16 0 0 1.01-.32 3.3 1.22a11.5 11.5 0 0 1 6 0c2.29-1.54 3.3-1.22 3.3-1.22.66 1.64.25 2.86.12 3.16.77.83 1.24 1.89 1.24 3.19 0 4.58-2.8 5.6-5.48 5.9.43.37.81 1.1.81 2.22v3.29c0 .32.21.7.82.58A12 12 0 0 0 12 .5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://www.linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5.001 2.5 2.5 0 0 1 0-5Zm.02 6H2v11h3V9.5Zm4 0H6v11h3v-6.1c0-1.62.3-3.19 2.32-3.19 1.99 0 2.01 1.86 2.01 3.29V20.5h3v-6.65c0-3.2-.69-5.67-4.42-5.67-1.79 0-2.99.98-3.49 1.9h-.05V9.5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://x.com/" target="_blank" rel="noopener" aria-label="X">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.2 2H21l-6.39 7.3L22 22h-6.8l-4.8-6.2L5 22H2.2l6.84-7.82L2 2h6.97l4.33 5.7L18.2 2Zm-1.2 18h1.88L7.08 4H5.14L17 20Z"/></svg>
                    </a>
                </div>
            </article>

            <article class="card">
                <div class="member">
                    <img class="avatar-img" src="img/mathis.JPG" alt="Clara Lefevre">
                    <div>
                        <h3 class="name">Mathis Hautbois</h3>
                        <p class="role">DevOps</p>
                    </div>
                </div>
                <p class="bio">Assure la stabilité, l'automatisation et les déploiements sécurisés.</p>
                <div class="tags">
                    <span class="tag">CI/CD</span>
                    <span class="tag">Monitoring</span>
                    <span class="tag">Support</span>
                </div>
                <div class="socials">
                    <a class="social-link" href="https://github.com/" target="_blank" rel="noopener" aria-label="GitHub">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5a12 12 0 0 0-3.79 23.39c.6.11.82-.26.82-.58v-2.02c-3.34.73-4.04-1.61-4.04-1.61-.55-1.4-1.35-1.77-1.35-1.77-1.1-.75.08-.74.08-.74 1.22.09 1.86 1.25 1.86 1.25 1.08 1.85 2.83 1.32 3.52 1.01.11-.78.42-1.32.76-1.63-2.66-.3-5.46-1.33-5.46-5.9 0-1.3.47-2.36 1.24-3.19-.13-.3-.54-1.52.12-3.16 0 0 1.01-.32 3.3 1.22a11.5 11.5 0 0 1 6 0c2.29-1.54 3.3-1.22 3.3-1.22.66 1.64.25 2.86.12 3.16.77.83 1.24 1.89 1.24 3.19 0 4.58-2.8 5.6-5.48 5.9.43.37.81 1.1.81 2.22v3.29c0 .32.21.7.82.58A12 12 0 0 0 12 .5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://www.linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5.001 2.5 2.5 0 0 1 0-5Zm.02 6H2v11h3V9.5Zm4 0H6v11h3v-6.1c0-1.62.3-3.19 2.32-3.19 1.99 0 2.01 1.86 2.01 3.29V20.5h3v-6.65c0-3.2-.69-5.67-4.42-5.67-1.79 0-2.99.98-3.49 1.9h-.05V9.5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://x.com/" target="_blank" rel="noopener" aria-label="X">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.2 2H21l-6.39 7.3L22 22h-6.8l-4.8-6.2L5 22H2.2l6.84-7.82L2 2h6.97l4.33 5.7L18.2 2Zm-1.2 18h1.88L7.08 4H5.14L17 20Z"/></svg>
                    </a>
                </div>
            </article>

            <article class="card">
                <div class="member">
                    <div class="avatar" data-initials="VD" aria-label="Avatar VD"></div>
                    <div>
                        <h3 class="name">Thomas Vinh-san</h3>
                        <p class="role">Data & Reporting</p>
                    </div>
                </div>
                <p class="bio">Met en valeur les données pour guider les décisions.</p>
                <div class="tags">
                    <span class="tag">SQL</span>
                    <span class="tag">Tableaux de bord</span>
                    <span class="tag">Analyse</span>
                </div>
                <div class="socials">
                    <a class="social-link" href="https://github.com/" target="_blank" rel="noopener" aria-label="GitHub">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 .5a12 12 0 0 0-3.79 23.39c.6.11.82-.26.82-.58v-2.02c-3.34.73-4.04-1.61-4.04-1.61-.55-1.4-1.35-1.77-1.35-1.77-1.1-.75.08-.74.08-.74 1.22.09 1.86 1.25 1.86 1.25 1.08 1.85 2.83 1.32 3.52 1.01.11-.78.42-1.32.76-1.63-2.66-.3-5.46-1.33-5.46-5.9 0-1.3.47-2.36 1.24-3.19-.13-.3-.54-1.52.12-3.16 0 0 1.01-.32 3.3 1.22a11.5 11.5 0 0 1 6 0c2.29-1.54 3.3-1.22 3.3-1.22.66 1.64.25 2.86.12 3.16.77.83 1.24 1.89 1.24 3.19 0 4.58-2.8 5.6-5.48 5.9.43.37.81 1.1.81 2.22v3.29c0 .32.21.7.82.58A12 12 0 0 0 12 .5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://www.linkedin.com/" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5.001 2.5 2.5 0 0 1 0-5Zm.02 6H2v11h3V9.5Zm4 0H6v11h3v-6.1c0-1.62.3-3.19 2.32-3.19 1.99 0 2.01 1.86 2.01 3.29V20.5h3v-6.65c0-3.2-.69-5.67-4.42-5.67-1.79 0-2.99.98-3.49 1.9h-.05V9.5Z"/></svg>
                    </a>
                    <a class="social-link" href="https://x.com/" target="_blank" rel="noopener" aria-label="X">
                        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.2 2H21l-6.39 7.3L22 22h-6.8l-4.8-6.2L5 22H2.2l6.84-7.82L2 2h6.97l4.33 5.7L18.2 2Zm-1.2 18h1.88L7.08 4H5.14L17 20Z"/></svg>
                    </a>
                </div>
            </article>
        </div>

        <section style="margin-top:28px;">
            <h2 style="margin:0 0 8px; font-size: 20px;">Ajout des photos</h2>
            <p style="margin:0; color:#555;">Nous ajouterons prochainement les photos officielles de l'équipe. Les initiales affichées sont temporaires et peuvent être remplacées par des images (format carré recommandé 512×512).</p>
        </section>
    </main>

    <footer>
        <p>© <?php echo date('Y'); ?> Orditrack — <a class="back-link" href="rgpd.php">Mentions légales</a></p>
    </footer>
</body>
</html>

