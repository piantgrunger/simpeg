<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //
        $series = [];
        $series2 = [];

        
        $dataPegawai = Yii::$app->db->createCommand(
            " SELECT jenis_pegawai,COUNT(*) as total
            FROM tb_m_pegawai
          
            where jenis_pegawai in ('Pegawai Negeri Sipil','Calon Pegawai Negeri Sipil')
            group BY jenis_pegawai
           "
        )->queryAll();
        foreach ($dataPegawai as $pegawai) {
            $series[] =
                [
                      'name' => strtoupper($pegawai['jenis_pegawai']),
                   'y' => (float) ($pegawai['total']),
                ];
        }

        $dataPangkat = Yii::$app->db->createCommand(
            ' SELECT kode_golongan,nama_golongan,COUNT(*) as total
        FROM tb_m_pegawai p
        inner join tb_m_golongan g on g.id_golongan=p.id_golongan
        
        group BY kode_golongan,nama_golongan
       '
        )->queryAll();
        foreach ($dataPangkat as $pangkat) {
            $series2[] =
            [
                  'name' => strtoupper($pangkat['nama_golongan'] . '(' . $pangkat['kode_golongan'] . ')'),
               'y' => (float) ($pangkat['total']),
            ];
        }
        $xSeries2 =  ArrayHelper::getColumn($series2, 'name');
         
        $dataEselon = Yii::$app->db->createCommand(
            ' SELECT nama_eselon,COUNT(*) as total
        FROM tb_m_pegawai p
        inner join tb_m_jabatan_fungsional f on f.id_jabatan_fungsional=p.id_jabatan_fungsional
        inner join tb_m_eselon e on e.id_eselon=f.id_eselon

        
        group BY nama_eselon
       '
        )->queryAll();
        foreach ($dataEselon as $pangkat) {
            $series3[] =
            [
                  'name' => strtoupper($pangkat['nama_eselon']),
               'y' => (float) ($pangkat['total']),
            ];
        }
        $xSeries3 =  ArrayHelper::getColumn($series3, 'name');
     
          $model = new LoginForm();
        return $this->render('index', ['model'=>$model,'series'=>$series,'series2'=>$series2,'xSeries2'=>$xSeries2,'series3'=>$series3,'xSeries3'=>$xSeries3]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $this->layout = 'main-login';
        
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
