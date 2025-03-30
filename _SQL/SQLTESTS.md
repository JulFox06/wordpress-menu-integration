# Test SQL

## Partie 1 : Questions basiques

1. Écrivez une requête pour récupérer tous les articles publiés (`post_type = 'post'` et `post_status = 'publish'`), triés par date de publication (du plus récent au plus ancien).

```sql
SELECT * FROM wp_posts 
    WHERE post_type = 'post'
      AND post_status = 'publish' 
    ORDER BY post_date DESC;
```

2. Écrivez une requête pour compter le nombre d'articles publiés par auteur, en affichant le nom de l'auteur et le nombre d'articles.

```sql
SELECT wp_users.display_name, COUNT(wp_posts.ID) 
    FROM wp_posts
    JOIN wp_users ON wp_posts.post_author = wp_users.ID
    WHERE wp_posts.post_type = 'post'
      AND wp_posts.post_status = 'publish';
```

3. Écrivez une requête pour récupérer le titre et la valeur d'une méta-donnée spécifique (par exemple `'_thumbnail_id'`) pour tous les articles publiés qui possèdent cette méta-donnée.

```sql
SELECT wp_posts.post_title, wp_postmeta.meta_value
    FROM wp_posts
    JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
    WHERE wp_posts.post_type = 'post'
      AND wp_posts.post_status = 'publish'
      AND wp_postmeta.meta_key = '_thumbnail_id';
```


## Partie 2 : Requêtes intermédiaires

1. Écrivez une requête pour trouver les 5 articles les plus récents avec leur auteur (nom d'affichage) et le nombre de métadonnées associées à chaque article.

```sql

```

2. Écrivez une requête pour récupérer tous les articles qui contiennent le mot "WordPress" dans leur contenu ou titre, en affichant l'ID, le titre et la date de publication.

```sql
SELECT wp_posts.ID, wp_posts.post_title, wp_posts.post_date
    FROM wp_posts
    WHERE wp_posts.post_type = 'post'
      AND (wp_posts.post_title LIKE '%WordPress%' OR wp_posts.post_content LIKE '%WordPress%')
    ORDER BY wp_posts.post_date DESC;
```

3. Écrivez une requête pour trouver tous les utilisateurs qui n'ont jamais publié d'article.

```sql
SELECT *
    FROM wp_users
    LEFT JOIN wp_posts
        ON wp_users.ID = wp_posts.post_author AND wp_posts.post_type = 'post' AND wp_posts.post_status = 'publish'
    WHERE wp_posts.ID IS NULL;
```


## Partie 3 : Requête avancée

```sql

```
