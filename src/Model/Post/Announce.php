<?php

namespace App\Model\Post;

use App\Action\Create\InsertInDb;
use App\Action\Update\UpdateDb;
use App\Auth\Session;
use App\Auth\Cookie;
use App\Communication\MailContentManager;
use App\File\Image\Image;
use App\Database\SqlQueryFormater;
use App\File\File;
use App\Model\User\Registered;
use App\Utility\Utility;
use App\Model\Post\Comment;
use App\Model\Category;
use App\Model\Model;

/**
 * Classe de gestion d'une annonce.
 */
class Announce extends Model
{
    private $category;
    private $subCategory;
    private $price;
    private $owner;
    private $userToJoin;
    private $phoneNumber;
    private $location;
    private $direction;
    private $type;
    private $status;
    private $postedAt;
    private $views;
    private $iconClass;
    private $premiumImgPath;
    private $premiumImgSrc;
    private $productImgPath;
    private $productImgSrc;
    private $productInfoImgPath;
    private $productInfoImgSrc;
    private $artInFooterImgPath;
    private $artInFooterImgSrc;
    const TABLE_NAME = "ind_announces";
    const IMG_DIR_PATH = Image::IMG_DIR_PATH . DIRECTORY_SEPARATOR . "productinfo" . DIRECTORY_SEPARATOR;
    const IMG_DIR_URL = Image::IMG_DIR_URL . "/productinfo";
    const DEFAULT_THUMBS = Image::IMG_DIR_URL . "/defaul-thumbs" . Image::EXTENSION;
    private static $statutes = ["suspended", "pending", "validated", "premium"];

    /**
     * Constructeur de l'objet annonce.
     * 
     * @param int $id
     */
    public function __construct(int $id)
    {
        $queryFormatter = new SqlQueryFormater();

        $query = $queryFormatter->select(
            "id, title, description, slug, id_category, id_sub_category, price,
            user_email_address, user_to_join, phone_number, location, direction, type,
            status, created_at, posted_at, updated_at, views, icon_class"
        )->from(self::TABLE_NAME)->where("id = ?")->returnQueryString();

        $req = parent::connectToDb()->prepare($query);
        $req->execute([$id]);

        $result = $req->fetch();

        $this->id = $result["id"];
        $this->title = $result["title"];
        $this->description = $result["description"];
        $this->slug = $result["slug"];
        $this->category = new Category($result["id_category"]);
        $this->subCategory = $result["id_sub_category"];
        $this->price = $result["price"];
        $this->userEmailAddress = $result["user_email_address"];
        $this->owner = new Registered($this->userEmailAddress);
        $this->userToJoin = $result["user_to_join"];
        $this->phoneNumber = $result["phone_number"];
        $this->location = $result["location"];
        $this->direction = $result["direction"];
        $this->type = $result["type"];
        $this->status = (int)$result["status"];
        $this->createdAt = $result["created_at"];
        $this->postedAt = $result["posted_at"];
        $this->updatedAt = $result["updated_at"];
        $this->views = (int)$result["views"];
        $this->iconClass = $result["icon_class"];
        $this->tableName = self::TABLE_NAME;

        $this->premiumImgPath = Image::PREMIUM_DIR_PATH . $this->slug . Image::EXTENSION;
        $this->premiumImgSrc = Image::PREMIUM_DIR_URL . "/" . $this->slug . Image::EXTENSION;

        $this->productImgPath = Image::PRODUCT_DIR_PATH . $this->slug . Image::EXTENSION;
        $this->productImgSrc = Image::PRODUCT_DIR_URL . "/" . $this->slug . Image::EXTENSION;

        $this->productInfoImgPath = Image::PRODUCT_INFO_DIR_PATH . $this->slug . Image::EXTENSION;
        $this->productInfoImgSrc = Image::PRODUCT_INFO_DIR_URL . "/" . $this->slug . Image::EXTENSION;

        $this->artInFooterImgPath = Image::ART_IN_FOOTER_PATH . $this->slug . Image::EXTENSION;
        $this->artInFooterImgSrc = Image::ART_IN_FOOTER_URL . "/" . $this->slug . Image::EXTENSION;
    }

    /**
     * Retourne la catégorie de l'annonce.
     * 
     * @return \App\Model\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Retourne la sous-catégorie de l'annonce.
     * 
     * @return SubCategory
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * Retourne l'utilisateur à qui appartient l'annonce.
     * 
     * @return Registered
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Retourne l'adresse email de l'utilisateur à joindre.
     * 
     * @return string
     */
    public function getUserToJoin()
    {
        if ($this->userToJoin) {
            return $this->userToJoin;
        } else {
            return $this->owner->getEmailAddress();
        }
    }

    /**
     * Retourne l'addresse email de celui qui a posté l'annonce.
     * 
     * @return string
     */
    public function getUserEmailAddress()
    {
        return $this->userEmailAddress;
    }

    /**
     * Retourne le numéro de téléphone enregistré lors de la création de l'annonce.
     * 
     * @return string
     */
    public function getPhoneNumber()
    {
        if ($this->phoneNumber) {
            return $this->phoneNumber;
        } else {
            return $this->owner->getPhoneNumber();
        }
    }

    /**
     * Retourne l'état de l'annonce.
     * 
     * @param string $lang
     * @return string
     */
    public function getStatus(string $lang = null)
    {
        if (in_array($lang, ["fr", "french", "français"])) {
            $statusInFrench = ["suspendue", "en attente", "validée", "premium"];
            return ucfirst($statusInFrench[$this->status]);
        } else {
            return ucfirst(self::$statutes[$this->status]);
        }
    }

    /**
     * Retourne la date de post de l'annonce.
     * 
     * @return string
     */
    public function getPostedAt()
    {
        return Utility::formatDate($this->postedAt, "day", true);
    }

    /**
     * Retourne le nombre de vue de l'annonce.
     * 
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Retourne l'icon de l'annonce.
     * 
     * @return string
     */
    public function getIconClass()
    {
        return $this->iconClass;
    }

    /**
     * Retourne la source de l'image dans la carte de premium de
     * format 600x400.
     * 
     * @return string
     */
    public function getPremiumImgSrc()
    {
        if (file_exists($this->premiumImgPath))
            return $this->premiumImgSrc;
        else
            return Image::PREMIUM_DIR_URL . "/default-img" . Image::EXTENSION;
    }

    /**
     * Retourne la source de l'image dans la carte product de format
     * 640x420.
     * 
     * @return string
     */
    public function getProductImgSrc()
    {
        if (file_exists($this->productImgPath))
            return $this->productImgSrc;
        else
            return Image::PRODUCT_DIR_URL . "/default-img" . Image::EXTENSION;
    }
    
    /**
     * Retourne la source de l'image qui se trouve dans le dossier
     * product info de format 625x415.
     * 
     * @return string
     */
    public function getProductInfoImgSrc()
    {
        if (file_exists(Image::PRODUCT_INFO_DIR_PATH . $this->slug . Image::EXTENSION))
            return $this->productInfoImgSrc;
        else
            return Image::PRODUCT_INFO_DIR_URL . "/default-img" . Image::EXTENSION;
    }

    /**
     * Retourne le lien de l'image dans le footer.
     * 
     * @return string
     */
    public function getArtInFooterImgSrc()
    {
        if (file_exists($this->artInFooterImgPath))
            return $this->artInFooterImgSrc;
        else 
            return Image::ART_IN_FOOTER_URL . "/default-img" . Image::EXTENSION;
    }

    /**
     * Retourne toutes les images de product info.
     * 
     * @return array
     */
    public function getProductAllImg()
    {
        if (file_exists(Image::PRODUCT_INFO_DIR_PATH . "/$this->slug" . "-0" . Image::EXTENSION)) {
            return [
                Image::PRODUCT_INFO_DIR_URL . "/$this->slug" . "-0" . Image::EXTENSION,
                Image::PRODUCT_INFO_DIR_URL . "/$this->slug" . "-1" . Image::EXTENSION,
                Image::PRODUCT_INFO_DIR_URL . "/$this->slug" . "-2" . Image::EXTENSION,
            ];
        } else {
            return [
                Image::PRODUCT_INFO_DIR_URL . "/default-img" . Image::EXTENSION,
            ];
        }
    }

    /**
     * Retourne la location de l'annonce.
     * 
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Retourne la direction de l'annonce.
     * @return string
     */
    public function getDirection()
    {
        return ucfirst($this->direction);
    }

    /**
     * Retourne le type d'annonce, particulier ou professionnel.
     * @return string
     */
    public function getType()
    {
        return ucfirst($this->type);
    }

    /**
     * Retourne le lien de l'annonce.
     * 
     * @param string $type Permet de dire si on veut le lien relatif au site
     *                     ou le lien total contenant le domaine.
     * 
     * @return string
     */
    public function getLink(string $type = null)
    {
        if (in_array($type, ["all", "total", "domain", "with domain", "with_domain"])) {
            return APP_URL . "/" . $this->category->getSlug() . "/" . $this->slug;
        } else {
            return $this->category->getSlug() . "/" . $this->slug;
        }
    }

    /**
     * Retourne le lien vers la page qui permet de modifier l'annonce.
     * 
     * @return string
     */
    public function getManageLink(string $action = null)
    {
        return null === $action
            ? $this->getLink() // Si on ne passe pas d'action on affiche l'annonce
            : $this->getLink()."/$action"; // Si on passe une annonce.
    }

    /**
     * Retourne le prix.
     * 
     * @param bool $withCurrency Permet de spécifier s'il faut retourner le prix avec la monnaie.
     * @return string
     */
    public function getPrice(bool $withCurrency = true)
    {
        if ($this->price === null) {
            return "Gratuit";
        } elseif ($this->price == "price_on_call") {
            return "Prix à l'appel";
        } else {
            return $withCurrency ? $this->price . " F CFA" : (int)$this->price;
        }
    }

    /**
     * Retourne les commentaires de cette annonce.
     */
    public function getComments()
    {
        $req = parent::connectToDb()->prepare("SELECT id FROM " . Comment::TABLE_NAME . " WHERE subject_id = ?");
        $req->execute([$this->id]);
        $result = $req->fetchAll();
        
        $comments = [];
        foreach ($result as $comment) {
            $comments[] = new Comment($comment["id"]);
        }

        return $comments;
    }

    /**
     * Retourne le dernier commentaire d'une annonce.
     * 
     * @return \App\Model\Post\Comment
     */
    public function getLastComment()
    {
        $req = parent::connectToDb()->prepare(
            "SELECT id FROM " . Comment::TABLE_NAME . " WHERE subject_id = :subject_id AND subject_type = :subject_type ORDER BY posted_at DESC limit 0, 1"
        );
        $req->execute([
            "subject_id" => $this->id,
            "subject_type" => $this->tableName
        ]);

        $commentId = $req->fetch()["id"];

        if ($commentId) {
            return new Comment((int)$commentId);
        }
    }

    /**
     * Permet de vérifier si c'est une annonce suspendue.
     * @return bool
     */
    public function isSuspended() : bool
    {
        return $this->status === 0;
    }

    /**
     * Permet de vérifier si c'est une annonce en attente de validation.
     * @return bool
     */
    public function isPending() : bool
    {
        return $this->status === 1;
    }

    /**
     * Permet de vérifier si c'est une annonce validée.
     * @return bool
     */
    public function isValidated() : bool
    {
        return $this->status === 2 || $this->status === 3;
    }

    /**
     * Permet de vérifier si c'est une annonce premium.
     * @return bool
     */
    public function isPremium() : bool
    {
        return $this->status === 3;
    }

    /**
     * Retourne un certain nombre d'annonces en fonction des paramètres
     * passés à la méthode.
     * 
     * @param int $idCategory Pour spécifier qu'on veut des annonces appartenant
     *                        à une catégorie précise.
     * @param string $status  Pour spécifier qu'on veut des annonces appartenant à
     *                        une sous-catégorie précise.
     * @param int $nbr        Pour spécifier qu'on veut un nombre d'annonces précis.
     */
    public static function getAll(int $idCategory = null, string $status = null, int $begining = null, int $nbr = null)
    {
        // Format de la requête à la base.
        $query = "SELECT id FROM " . self::TABLE_NAME;
        if ($status) {
            $status = self::convertStatus($status);
        }

        // Si on passe une catégorie précise et un status précise.
        if ($idCategory && $status) {
            $query .= " WHERE id_category = ? AND status = ?";
            // Si on spécifie un nombre d'annonces précis
            if ($nbr) {
                $query .= " LIMIT $begining, $nbr";
            }
            $req = parent::connectToDb()->prepare($query);
            $req->execute([$idCategory, $status]);

        } elseif ($idCategory && !$status) { // Si on spécifie que la catégorie
            $query .= " WHERE id_category = ?";
            // Si on spécifie un nombre d'annonces précis
            if ($nbr) {
                $query .= " LIMIT $begining, $nbr";
            }
            $req = parent::connectToDb()->prepare($query);
            $req->execute([$idCategory]);

        } elseif (!$idCategory && $status) { // Si on spécifie que la sous-catégorie
            $query .= " WHERE status = ?";
            // Si on spécifie un nombre d'annonces précis
            if ($nbr) {
                $query .= " LIMIT $begining, $nbr";
            }
            $req = parent::connectToDb()->prepare($query);
            $req->execute([$status]);

        } else {
            // Si on spécifie un nombre d'annonces précis
            if ($nbr) {
                $query .= " LIMIT $begining, $nbr";
            }
            $req = parent::connectToDb()->query($query);
        }

        $result = $req->fetchAll();

        $announces = [];
        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces par orde de création, de la plus récente à la plus
     * ancienne.
     * 
     * @param int $nbr Pour spécifier si on veut un nombre d'annonces précis.
     * 
     * @return array
     */
    public static function getLastPosted(int $nbr = null) : array
    {
        $query = "SELECT id FROM " . self::TABLE_NAME . " WHERE status IN (2, 3) ORDER BY status DESC, created_at DESC";

        if ($nbr) {
            $query .= " LIMIT 0, $nbr";
        }

        $req = parent::connectToDb()->query($query);
        $result = $req->fetchAll();

        $announces = [];

        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces les plus vues.
     * 
     * @param int $nbr Pour spécifier si on veut un nombre d'annonces précis.
     * 
     * @return array
     */
    public static function getMostViewed(int $nbr = null) : array
    {
        $query = "SELECT id FROM " . self::TABLE_NAME . " WHERE status IN (2, 3) ORDER BY views DESC";

        if ($nbr) {
            $query .= " LIMIT 0, $nbr";
        }

        $req = parent::connectToDb()->query($query);
        $result = $req->fetchAll();

        $announces = [];
        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Permet de créer une nouvelle ligne d'annonce et d'enregistrer les données.
     */
    public static function create() : bool
    {
        $image = new Image();
        $data["title"] = htmlspecialchars($_POST["title"]);
        $data["description"] = htmlspecialchars($_POST["description"]);
        $data["id_category"] = htmlspecialchars($_POST["id_category"]);
        $data["location"] = htmlspecialchars($_POST["location"]);
        $data["type"] = htmlspecialchars($_POST["type"]);
        $data["direction"] = htmlspecialchars($_POST["direction"]);

        if (empty($_POST["price"]) && isset($_POST["price_on_call"])) {
            $data["price"] = "price_on_call";
        } else {
            $data["price"] = htmlspecialchars($_POST["price"]);
        }

        if (isset($_POST["usertype"]) && $_POST["usertype"] === "someone_else") {
            $data["user_to_join"] = $_POST["user_to_join"];
            $data["phone_number"] = $_POST["phone_number"];
        }

        $data["user_email_address"] = Session::getRegistered() ?? Cookie::getRegistered();

        $insertion = new InsertInDb($data, self::TABLE_NAME, DB_NAME, DB_LOGIN, DB_PASSWORD);
        $insertion->run();

        $currentAnnounce = new self($insertion->getPDO()->lastInsertId());

        $slug = Utility::slugify($_POST["title"]) . "-" . $currentAnnounce->getId();
        $currentAnnounce->set("slug", $slug, "id", $currentAnnounce->getId());

        $currentAnnounce = new self($insertion->getPDO()->lastInsertId());

        if (File::fileIsUploaded("images")) {
            $currentAnnounce->saveImages($currentAnnounce->getSlug());
        }
        
        return true;
    }

    /**
     * Permet de mettre à jour l'annonce.
     * 
     * @return bool
     */
    public function update()
    {
        $image = new Image();
        $data["title"] = htmlspecialchars($_POST["title"]);
        $data["description"] = htmlspecialchars($_POST["description"]);
        $data["id_category"] = htmlspecialchars($_POST["id_category"]);
        $data["location"] = htmlspecialchars($_POST["location"]);
        $data["type"] = htmlspecialchars($_POST["type"]);
        $data["direction"] = htmlspecialchars($_POST["direction"]);
        
        //=== Fonctionnalité rétirée pour le moment ====/
        // $data["id_sub_category"] = htmlspecialchars($_POST["id_sub_category"]);

        //=== Si l'user veut qu'on l'appelle pour le prix ======================/
        if (empty($_POST["price"]) && isset($_POST["price_on_call"])) {
            $data["price"] = "price_on_call";
        } else {
            $data["price"] = htmlspecialchars($_POST["price"]);
        }

        //=== Si user à choisi un autre utilisateur à contacter =================/
        if ((isset($_POST["usertype"]) && $_POST["usertype"] === "someone_else")
            || (!empty($_POST["user_to_join"]) && !empty($_POST["phone_number"]))
        ) {
            $data["user_to_join"] = $_POST["user_to_join"];
            $data["phone_number"] = $_POST["phone_number"];
        }

        // Si le tire ne change pas
        if ($this->title === $_POST["title"]) {
            // nouvelles images
            if (!empty($_FILES["images"]["name"][0])) {
                // on enregistre les images avec les anciens noms
                $this->saveImages($this->slug);
            }
        }
        // Si le titre change
        else {
            // on reformate le slug = slug du tire + id
            $slug = Utility::slugify($_POST["title"]) ."-". $this->id;
            // on reformate le nom des images
            $imgName = $slug;
            // Si aucunes images postées
            if (empty($_FILES["images"]["name"][0])) {
                // on renomme les images
                $this->renameImages($imgName);
            } else {
                // Si des images ont été postées
                if (!empty($_FILES["images"]["name"][0])) {
                    // on supprime les anciennes
                    $this->deleteImages();
                    // on enregistre les nouvelles avec les noms
                    $this->saveImages($imgName);
                }
            }
            $this->set("slug", $slug, "id", $this->id);
        }

        // Mise à jour des données
        $update = new UpdateDb($data, DB_NAME, $this->tableName, DB_LOGIN, DB_PASSWORD, ["id" => $this->id]);
        $update->run();
        return true;
    }

    /**
     * Permet de supprimer une annonce.
     * 
     * @return bool
     */
    public function delete()
    {
        if ($this->deleteImages()) {
            if (parent::delete()) {
                return true;
            }
        }
    }

    /**
     * Retourne les annonces suspendue.
     * 
     * @return array
     */
    public static function getSuspended() : array
    {
        $query = "SELECT id FROM ". self::TABLE_NAME . " WHERE status = 0";
        $req = parent::connectToDb()->query($query);

        $result = $req->fetchAll();

        $announces = [];

        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces en pending.
     * 
     * @return array
     */
    public static function getPending() : array
    {
        $query = "SELECT id FROM ". self::TABLE_NAME . " WHERE status = 1";
        $req = parent::connectToDb()->query($query);

        $result = $req->fetchAll();

        $announces = [];

        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces validées.
     * 
     * @return array
     */
    public static function getValidated(int $idCategory = null) : array
    {
        $query = "SELECT id FROM ". self::TABLE_NAME . " WHERE status IN (2, 3) ORDER BY status";

        if ($idCategory) {
            $query .= " AND id_category = ?";
            $req = parent::connectToDb()->prepare($query);
            $req->execute([$idCategory]);
        } else {
            $req = parent::connectToDb()->query($query);
        }

        $announces = [];

        foreach($req->fetchAll() as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les annonces premium.
     * 
     * @return array
     */
    public static function getPremium(int $nbr)
    {
        $query = "SELECT id FROM ". self::TABLE_NAME . " WHERE status = 3";
        $req = parent::connectToDb()->query($query);

        $result = $req->fetchAll();

        $announces = [];

        foreach($result as $announce) {
            $announces[] = new self($announce["id"]);
        }

        return $announces;
    }

    /**
     * Retourne les statuts.
     * 
     * @return array
     */
    public static function getStatutes()
    {
        return self::$statutes;
    }

    /**
     * Convertit le statut passé en chaîne de caractère
     * en chiffre.
     * 
     * @param string $status
     * 
     * @return int
     */
    public static function convertStatus(string $status)
    {
        if (is_string($status)) {
            $key = array_keys(self::$statutes, strtolower($status));
            if (count($key) === 1) {
                return $key[0];
            } else {
                return null;
            }
        } else {
            return $status;
        }
    }

    /**
     * Permet de vérifier que l'élément passé en paramètre a
     * est parent de cet élément.
     * 
     * @param Category $category
     */
    public function hasCategory(Category $category)
    {
        return $this->category->getId() === $category->getId();
    }

    /**
     * Permet de vérifier que l'utilisateur passé en paramètre est 
     * le owner de cette annonce.
     * 
     * @return bool
     */
    public function hasOwner(\App\Model\User\Registered $registered)
    {
        return $this->owner->getEmailAddress() === $registered->getEmailAddress();
    }

    /**
     * Permet de sauvegarder les images de cette l'annonce.
     */
    private function saveImages(string $imgName)
    {
        $image = new Image();
        // Format premium 600 x 400
        $image->save($_FILES['images']['tmp_name'][0], $imgName, Image::PREMIUM_DIR_PATH, 600, 400);

        // Product 640 x 420
        $image->save($_FILES['images']['tmp_name'][0], $imgName, Image::PRODUCT_DIR_PATH, 640, 420);

        // Art in Footer 240 x 200
        $image->save($_FILES['images']['tmp_name'][0], $imgName, Image::ART_IN_FOOTER_PATH, 240, 200);

        // ProductInfo 625x415
        $arrayLength = count($_FILES["images"]["tmp_name"]);
        for ($i = 0; $i < $arrayLength; $i++) {
            $image->save($_FILES['images']['tmp_name'][$i], $imgName ."-". $i, Image::PRODUCT_INFO_DIR_PATH, 625, 415);
        }

        return true;
    }

    /**
     * Permet de renommer les images de cette annonce.
     * 
     * @param string $newImgPath Le chemin où se trouve le
     */
    private function renameImages(string $newImgName)
    {
        $image = new Image();
        // Premium Img
        $image->rename($this->premiumImgPath, Image::PREMIUM_DIR_PATH . $newImgName . Image::EXTENSION);

        // Product Img
        $image->rename($this->productImgPath, Image::PRODUCT_DIR_PATH . $newImgName . Image::EXTENSION);

        // Art in Footer Img
        $image->rename($this->artInFooterImgPath, Image::ART_IN_FOOTER_PATH . $newImgName . Image::EXTENSION);

        // ProductInfo Img
        for ($i = 0; $i < 3; $i++) {
            $image->rename(Image::PRODUCT_INFO_DIR_PATH . $this->slug ."-". $i . Image::EXTENSION , Image::PRODUCT_INFO_DIR_PATH . $newImgName ."-". $i . Image::EXTENSION);
        }

        return true;
    }

    /**
     * Permet de supprimer les images de cette annonce.
     */
    private function deleteImages()
    {
        $image = new Image();
        
        // Format premium 600 x 400
        $image->delete($this->premiumImgPath);

        // Product 640 x 420
        $image->delete($this->productImgPath);

        // Art in Footer 240 x 200
        $image->delete($this->artInFooterImgPath);

        // ProductInfo 625x415
        for ($i = 0; $i < 3; $i++) {
            $image->delete(Image::PRODUCT_INFO_DIR_PATH . $this->slug ."-". $i . Image::EXTENSION);
        }

        return true;
    }

    /**
     * Message envoyé lorsqu'une mise à jour vient d'être faite.
     * 
     * @return string
     */
    public function updatingEmailNotification()
    {
        return <<<HTML
        <p>Une annonce vient d'être mise à jour.</p>
        <p>
            Id de l'annonce : {$this->id}<br>
            Utilisateur : {$this->owner->getEmailAddress()}
            Date de mise à jour {$this->getUpdatedAt()}
        </p>
        <p>
            <a href="{$this->getLink('all')}">Voir</a>
        </p>
HTML;
    }

    /**
     * Permet d'incrémenter le nombre de vue.
     * 
     * @return bool
     */
    public function incrementView()
    {
        if ($this->isValidated()) {
            $req = parent::connectToDb()->prepare("UPDATE " . self::TABLE_NAME . " SET views = views + 1 WHERE id = :id");
            $req->execute([
                "id" => $this->id
            ]);
    
            return true;
        }
    }

    public static function getCurrentDayPosts()
    {
        $query = "SELECT id FROM " . self::TABLE_NAME . " WHERE DATE(created_at) = :date";
        $req = parent::connectToDb()->prepare($query);
        $req->execute([
            "date" => date("Y-m-d"),
        ]);
        $result = $req->fetchAll();

        $currentDayAnnounces = [];
        foreach($result as $item) {
            $currentDayAnnounces[] = new self($item["id"]);
        }

        return $currentDayAnnounces;
    }

    /**
     * Retourne le sujet du mail envoyé lorsque l'announce est validée.
     * 
     * @return string
     */
    public function validatedAnnounceEmailSubject()
    {
        return "Votre annonce $this->title vient d'être validée";
    }

    /**
     * Retourne le contenu du mail envoyé lorsque l'annonce est validée.
     * 
     * @return string
     */
    public function validatedAnnounceEmailContent()
    {
        $content = <<<HTML
        Félicitations !
        Votre annonce avec le titre : {$this->title} a été validée. Elle est maintenant visible par tous les utilisateurs.
HTML;
        return MailContentManager::contentFormater($content);
    }

}