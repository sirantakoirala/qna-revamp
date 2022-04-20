import { useUserContext } from "../../context/userContext";
import { db } from "../../firebase-config";
import { useEffect, useState } from "react";
import { collection, query, getDocs, where } from "firebase/firestore";
import { Sidebar } from "../Dashboard/Sidebar";
import { useParams } from "react-router-dom";
import { Button, Card, Image, Form, Radio, Message } from "semantic-ui-react";
import QuizModal from "../Dashboard/QuizModal";

export const Quiz = () => {
  const { subject } = useParams();
  const { currentUser } = useUserContext();
  const isNotStudentRole = currentUser.role !== "student";
  const [formState, setFormState] = useState({});
  const [submitted, setSubmitted] = useState(false);
  const [score, setScore] = useState(0);

  const [subjectQuizzes, setSubjectQuizzes] = useState([]);
  useEffect(() => {
    async function getSubjects() {
      const q = query(
        collection(db, "quizzes"),
        where("subject", "==", subject)
      );

      const querySnapshot = await getDocs(q);
      const quizzes = querySnapshot.docs.map((doc) => doc.data());

      setSubjectQuizzes(quizzes);
    }
    getSubjects();
  }, []);

  const handleScore = (ev) => {
    ev.preventDefault();
    const score = subjectQuizzes.filter(
      (quiz) => formState[quiz.quizId] === quiz.correctAnswer
    ).length;
    setScore(score);
    setSubmitted(true);
  };
  const options = [{ key: "1", text: subject, value: subject }];
  if (subjectQuizzes.length === 0) {
    return (
      <Sidebar>
        <h1>Quiz - {subject}</h1>

        <div style={{ padding: "20px 0" }}>
          {isNotStudentRole && (
            <QuizModal subjectOptions={options} currentUser={currentUser} />
          )}
        </div>
        <Message>
          <Message.Header>No quizzes found</Message.Header>
          <p>Currently no quizzes is available for this particular subject</p>
        </Message>
      </Sidebar>
    );
  }
  return (
    <Sidebar>
      <h1>Quiz - {subject}</h1>

      {submitted && (
        <Message
          success
          header="Your current score is"
          content={`${score}/${subjectQuizzes.length}`}
        />
      )}

      <div style={{ padding: "20px 0" }}>
        {isNotStudentRole && (
          <QuizModal subjectOptions={options} currentUser={currentUser} />
        )}
      </div>

      <Form onSubmit={handleScore}>
        {subjectQuizzes.map((quiz) => {
          return (
            <Card style={{ width: "100%" }} key={quiz.quizId}>
              <Card.Content>
                <Card.Header>{quiz.question}</Card.Header>
                <Card.Description></Card.Description>
              </Card.Content>
              <Card.Content extra>
                <Form.Field>
                  <Radio
                    label={quiz.answer1}
                    name={quiz.quizId}
                    value={quiz.answer1}
                    onChange={(e, { value }) =>
                      setFormState({ ...formState, [quiz.quizId]: value })
                    }
                  />
                </Form.Field>
                <Form.Field>
                  <Radio
                    label={quiz.answer2}
                    name={quiz.quizId}
                    value={quiz.answer2}
                    onChange={(e, { value }) =>
                      setFormState({ ...formState, [quiz.quizId]: value })
                    }
                  />
                </Form.Field>
                <Form.Field>
                  <Radio
                    label={quiz.answer3}
                    name={quiz.quizId}
                    value={quiz.answer3}
                    onChange={(e, { value }) =>
                      setFormState({ ...formState, [quiz.quizId]: value })
                    }
                  />
                </Form.Field>
                <Form.Field>
                  <Radio
                    label={quiz.answer4}
                    name={quiz.quizId}
                    value={quiz.answer4}
                    onChange={(e, { value }) =>
                      setFormState({ ...formState, [quiz.quizId]: value })
                    }
                  />
                </Form.Field>
              </Card.Content>
            </Card>
          );
        })}
        <Button primary type="submit">
          Submit
        </Button>
      </Form>
    </Sidebar>
  );
};
